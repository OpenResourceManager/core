<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Account;
use App\Http\Models\API\Course;
use App\Http\Models\API\Department;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Room;
use App\Http\Transformers\AccountTransformer;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;


class AccountController extends ApiController
{

    /**
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->noun = 'account';
    }

    /**
     * Show all Accounts
     *
     * Get a paginated array of Accounts.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Account::with(['emails', 'mobilePhones', 'addresses'])->paginate($this->resultLimit);
        return $this->response->paginator($accounts, new AccountTransformer);
    }

    /**
     * Select Account by ID
     *
     * View a single Account by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $account = Account::with(['emails', 'mobilePhones', 'addresses'])->findOrFail($id);
        return $this->response->item($account, new AccountTransformer);
    }

    /**
     * Select Account by Username
     *
     * View a single Account by providing it's Username attribute.
     *
     * @param $username
     * @return \Dingo\Api\Http\Response
     */
    public function showFromUsername($username)
    {
        $account = Account::where('username', $username)->with(['emails', 'mobilePhones', 'addresses'])->firstOrFail();
        return $this->response->item($account, new AccountTransformer);
    }

    /**
     * Select Account by Identifier
     *
     * View a single Account by providing it's Identifier attribute.
     *
     * @param $identifier
     * @return \Dingo\Api\Http\Response
     */
    public function showFromIdentifier($identifier)
    {
        $account = Account::where('identifier', $identifier)->with(['emails', 'mobilePhones', 'addresses'])->firstOrFail();
        return $this->response->item($account, new AccountTransformer);
    }

    /**
     * Store/Save/Restore Account
     *
     * Create or update Account information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $restore_account = null;
        $duty = null;
        $account = Input::all();

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required|max:7|min:6',
            'name_prefix' => 'string|max:20',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:20',
            'name_phonetic' => 'string',
            'username' => 'string|required|min:3',
            'primary_duty' => 'integer',
            'primary_duty_code' => 'string|exists:duties,code,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());
        }

        if (!empty(Input::get('primary_duty_code'))) {
            $duty = Duty::where('code', Input::get('primary_duty_code'))->firstOrFail();
            $account['primary_duty'] = $duty->id;
        } else if (!empty(Input::get('primary_duty'))) {
            $duty = Duty::findOrFail(Input::get('primary_duty'));
            $account['primary_duty'] = $duty->id;
        } else {
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', ['Neither a "primary_duty_code" or "primary_duty" value was provided.']);
        }
        // If the account is trashed restore them first.
        if ($accountToRestore = Account::onlyTrashed()->where('identifier', $data['identifier'])->first()) {
            $accountToRestore->restore();
            $restore_account = Account::where('identifier', $data['identifier'])->first();
        }

        $item = Account::updateOrCreate(['identifier' => Input::get('identifier')], $account);

        if (!empty($restore_account) && !$item->wasRecentlyCreated) {
            if ($account['primary_duty'] !== $restore_account->primary_duty) {
                // @todo Broadcast with redis to notify the event server
                $item->duties()->detach($restore_account->primary_duty);
                $item->duties()->attach($account['primary_duty']);
            } elseif ($item->wasRecentlyCreated) {
                $item->duties()->attach($account['primary_duty']);
            }
        }

        $trans = new AccountTransformer();
        $item = $trans->transform($item);

        return $this->response->created(route('api.accounts.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Account
     *
     * Deletes the specified Account by it's ID, Identifier, or Username attribute.
     *
     * @return mixed
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,id|exists:accounts,username,deleted_at,NULL',
            'id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not destroy account.', $validator->errors()->all());

        if (array_key_exists('id', $data)) {
            $deleted = Account::destroy($data['id']);
        } elseif (array_key_exists('identifier', $data)) {
            $deleted = Account::where('identifier', $data['identifier'])->firstOrFail()->delete();
        } elseif (array_key_exists('username', $data)) {
            $deleted = Account::where('username', $data['username'])->firstOrFail()->delete();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', ['You must supply one of the following fields "id", "identifier", or "username".']);
        }

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure('account');
    }


    /**
     * Assign Account to Duty
     *
     * Creates the relationship between an Account and Duty.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function assignDuty(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:duty_id|exists:duties,code,deleted_at,NULL',
            'duty_id' => 'integer|required_without:code|exists:duties,id,deleted_at,NULL'
        ]);


        if ($validator->fails())
            throw new StoreResourceFailedException('Could not assign duty to account.', $validator->errors());

        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new StoreResourceFailedException('Could not assign duty to ' . $this->noun . '.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('duty_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['duty_id'] = Duty::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not assign duty to ' . $this->noun . '.', ['You must supply a "duty_id" or "code" parameter.']);
            }
        }

        $account->duties()->attach($data['duty_id']);

        return $this->response->created();
    }


    /**
     * Detach Duty from Account
     *
     * Destroys the relationship between an Account and Duty.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detachDuty(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:duty_id|exists:duties,code,deleted_at,NULL',
            'duty_id' => 'integer|required_without:code|exists:duties,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from duty.', $validator->errors());


        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from duty.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('duty_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['duty_id'] = Duty::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not detach ' . $this->noun . ' from duty.', ['You must supply a "duty_id" or "code" parameter.']);
            }
        }

        $account->duties()->detach($data['duty_id']);

        if ($data['duty_id'] === $account->primary_duty) {
            $account->primary_duty = null;
            $account->save();
        }

        return $this->destroySuccessResponse();
    }


    /**
     * Assign Account to Course
     *
     * Creates the relationship between an Account and Course.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function assignCourse(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:course_id|exists:courses,code,deleted_at,NULL',
            'course_id' => 'integer|required_without:code|exists:courses,id,deleted_at,NULL'
        ]);


        if ($validator->fails())
            throw new StoreResourceFailedException('Could not assign course to account.', $validator->errors());

        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new StoreResourceFailedException('Could not assign course to ' . $this->noun . '.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('course_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['course_id'] = Course::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not assign course to ' . $this->noun . '.', ['You must supply a "course_id" or "code" parameter.']);
            }
        }

        $account->courses()->attach($data['course_id']);

        return $this->response->created();
    }

    /**
     * Detach Course from Account
     *
     * Destroys the relationship between an Account and Course.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detachCourse(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:course_id|exists:courses,code,deleted_at,NULL',
            'course_id' => 'integer|required_without:code|exists:courses,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from course.', $validator->errors());


        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from course.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('course_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['course_id'] = Course::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not detach ' . $this->noun . ' from course.', ['You must supply a "course_id" or "code" parameter.']);
            }
        }

        $account->courses()->detach($data['course_id']);

        return $this->destroySuccessResponse();
    }


    /**
     * Assign Account to Department
     *
     * Creates the relationship between an Account and Department.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function assignDepartment(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:department_id|exists:departments,code,deleted_at,NULL',
            'department_id' => 'integer|required_without:code|exists:departments,id,deleted_at,NULL'
        ]);


        if ($validator->fails())
            throw new StoreResourceFailedException('Could not assign department to account.', $validator->errors());

        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new StoreResourceFailedException('Could not assign department to ' . $this->noun . '.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('department_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['department_id'] = Department::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not assign department to ' . $this->noun . '.', ['You must supply a "department_id" or "code" parameter.']);
            }
        }

        $account->departments()->attach($data['department_id']);

        return $this->response->created();
    }

    /**
     * Detach Department from Account
     *
     * Destroys the relationship between an Account and Department.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detachDepartment(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:department_id|exists:departments,code,deleted_at,NULL',
            'department_id' => 'integer|required_without:code|exists:departments,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from department.', $validator->errors());


        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from department.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('department_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['department_id'] = Department::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not detach ' . $this->noun . ' from department.', ['You must supply a "department_id" or "code" parameter.']);
            }
        }

        $account->departments()->detach($data['department_id']);

        return $this->destroySuccessResponse();
    }


    /**
     * Assign Account to Room
     *
     * Creates the relationship between an Account and Room.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response|void
     */
    public function assignRoom(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:room_id|exists:rooms,code,deleted_at,NULL',
            'room_id' => 'integer|required_without:code|exists:rooms,id,deleted_at,NULL'
        ]);


        if ($validator->fails())
            throw new StoreResourceFailedException('Could not assign room to account.', $validator->errors());

        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new StoreResourceFailedException('Could not assign room to ' . $this->noun . '.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('room_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['room_id'] = Room::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not assign room to ' . $this->noun . '.', ['You must supply a "room_id" or "code" parameter.']);
            }
        }

        $account->rooms()->attach($data['room_id']);

        return $this->response->created();
    }

    /**
     * Detach Room from Account
     *
     * Destroys the relationship between an Account and Room.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detachRoom(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:room_id|exists:rooms,code,deleted_at,NULL',
            'room_id' => 'integer|required_without:code|exists:rooms,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from room.', $validator->errors());


        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from room.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('room_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['room_id'] = Room::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not detach ' . $this->noun . ' from room.', ['You must supply a "room_id" or "code" parameter.']);
            }
        }

        $account->rooms()->detach($data['room_id']);

        return $this->destroySuccessResponse();
    }

}
