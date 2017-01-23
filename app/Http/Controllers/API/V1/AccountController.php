<?php

namespace App\Http\Controllers\API\V1;

use App\Events\Api\Account\AssignedCourse;
use App\Events\Api\Account\AssignedDepartment;
use App\Events\Api\Account\AssignedDuty;
use App\Events\Api\Account\AssignedRoom;
use App\Events\Api\Account\UnassignedCourse;
use App\Events\Api\Account\UnassignedDepartment;
use App\Events\Api\Account\UnassignedDuty;
use App\Events\Api\Account\UnassignedRoom;
use App\Http\Models\API\Account;
use App\Http\Models\API\Course;
use App\Http\Models\API\Department;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Room;
use App\Http\Transformers\AccountTransformer;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\Api\Account\AccountsViewed;
use App\Events\Api\Account\AccountViewed;
use App\Models\Access\Permission\Permission;

class AccountController extends ApiController
{

    /**
     * AccountController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
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
        event(new AccountsViewed($accounts->pluck('id')->toArray()));
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
        event(new AccountViewed($account));
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
        event(new AccountViewed($account));
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
        event(new AccountViewed($account));
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

        if (array_key_exists('ssn', $data)
            || array_key_exists('password', $data)
            || array_key_exists('birth_date', $data)
        ) {
            $user = auth()->user();
            if ($user->hasPermission(Permission::where('name', 'write-classified')->firstOrFail())) {
                $classifiedValidator = Validator::make($data, [
                    'ssn' => 'size:4|nullable',
                    'password' => 'string|min:6|nullable',
                    'should_propagate_password' => 'boolean|nullable',
                    'birth_date' => 'date|nullable'
                ]);
                if ($classifiedValidator->fails()) {
                    throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $classifiedValidator->errors());
                }
            } else {
                throw new UnauthorizedHttpException('You are not authorized to write classified information. Hint: request greater access or remove any `ssn`, `password`, or `birth_date` references in your post data.');
            }
            // Encrypt any ssns, passwords, or birth dates.
            if (array_key_exists('ssn', $data)) $data['ssn'] = encrypt($data['ssn']);
            if (array_key_exists('password', $data)) $data['password'] = encrypt($data['password']);
            if (array_key_exists('birth_date', $data)) $data['birth_date'] = encrypt($data['birth_date']);
        }

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required|max:7|min:6',
            'name_prefix' => 'string|max:20',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:20',
            'name_phonetic' => 'string',
            'username' => 'string|required|min:3',
            'primary_duty_id' => 'integer|required_without:primary_duty_code|exists:duties,id,deleted_at,NULL',
            'primary_duty_code' => 'string|required_without:primary_duty_id|exists:duties,code,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());
        }

        // Convert the primary_duty_code to an id if needed
        if (!array_key_exists('primary_duty_id', $data)) {
            if (array_key_exists('primary_duty_code', $data)) {
                $data['primary_duty_id'] = Duty::where('code', $data['primary_duty_code'])->firstOrFail()->id;
            } else {
                throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', ['Neither a "primary_duty_code" or "primary_duty_id" value was provided.']);
            }
        }

        // If the account is trashed restore them first.
        if ($accountToRestore = Account::onlyTrashed()->where('identifier', $data['identifier'])->first()) {
            $accountToRestore->restore();
            $restore_account = Account::where('identifier', $data['identifier'])->first();
        }

        $item = Account::updateOrCreate(['identifier' => $data['identifier']], $data);

        // If the item was restored detach it's old duty and attach it to it's new duty
        // If it's a new account just attach it to it's primary duty
        if (!empty($restore_account) && !$item->wasRecentlyCreated) {
            if ($data['primary_duty_id'] !== $restore_account->primary_duty_id) {
                if ($item->duties()->detach($restore_account->primary_duty_id)) {
                    event(new UnassignedDuty($item, Duty::find($restore_account->primary_duty_id)));
                }
                if ($item->duties()->attach($data['primary_duty_id'])) {
                    event(new AssignedDuty($item, Duty::find($data['primary_duty_id'])));
                }
            } elseif ($item->wasRecentlyCreated) {
                if ($item->duties()->attach($data['primary_duty_id'])) {
                    event(new AssignedDuty($item, Duty::find($data['primary_duty_id'])));
                }
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
     * @return \Dingo\Api\Http\Response
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

        if ($account->duties()->attach($data['duty_id'])) {
            event(new AssignedDuty($account, Duty::find($data['duty_id'])));
        }
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
        event(new UnassignedDuty($account, Duty::find($data['duty_id'])));
        return $this->destroySuccessResponse();
    }


    /**
     * Assign Account to Course
     *
     * Creates the relationship between an Account and Course.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
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

        if ($account->courses()->attach($data['course_id'])) {
            event(new AssignedCourse($account, Course::find($data['course_id'])));
        }
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

        if ($account->courses()->detach($data['course_id'])) {
            event(new UnassignedCourse($account, Course::find($data['course_id'])));
        }
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

        if ($account->departments()->attach($data['department_id'])) {
            event($account, new AssignedDepartment($account, Department::find($data['department_id'])));
        }
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

        if ($account->departments()->detach($data['department_id'])) {
            event($account, new UnassignedDepartment($account, Department::find($data['department_id'])));
        }
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

        if ($account->rooms()->attach($data['room_id'])) {
            event($account, new AssignedRoom($account, Room::find($data['room_id'])));
        }
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

        if ($account->rooms()->detach($data['room_id'])) {
            event($account, new UnassignedRoom($account, Room::find($data['room_id'])));
        }
        return $this->destroySuccessResponse();
    }

}
