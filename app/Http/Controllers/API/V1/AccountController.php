<?php

namespace App\Http\Controllers\API\V1;

use App\Events\Api\Account\AccountUpdated;
use App\Events\Api\Account\AssignedCourse;
use App\Events\Api\Account\AssignedDepartment;
use App\Events\Api\Account\AssignedDuty;
use App\Events\Api\Account\AssignedRoom;
use App\Events\Api\Account\AssignedSchool;
use App\Events\Api\Account\UnassignedCourse;
use App\Events\Api\Account\UnassignedDepartment;
use App\Events\Api\Account\UnassignedDuty;
use App\Events\Api\Account\UnassignedRoom;
use App\Events\Api\Account\UnassignedSchool;
use App\Http\Models\API\Account;
use App\Http\Models\API\Course;
use App\Http\Models\API\Department;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Room;
use App\Http\Models\API\School;
use App\Http\Transformers\AccountTransformer;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\Api\Account\AccountsViewed;
use App\Events\Api\Account\AccountViewed;
use App\Models\Access\Permission\Permission;
use App\Http\Models\API\LoadStatus;
use PDOException;

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
        $accounts = Account::with(['emails', 'mobilePhones', 'addresses', 'duties', 'courses.department', 'departments', 'aliasAccounts', 'loadStatus', 'schools'])->paginate($this->resultLimit);
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
        $account = Account::with(['emails', 'mobilePhones', 'addresses', 'duties', 'courses.department', 'departments', 'aliasAccounts', 'loadStatus', 'schools'])->findOrFail($id);
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
        $account = Account::where('username', $username)->with(['emails', 'mobilePhones', 'addresses', 'duties', 'courses.department', 'departments', 'aliasAccounts', 'loadStatus', 'schools'])->firstOrFail();
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
        $account = Account::where('identifier', $identifier)->with(['emails', 'mobilePhones', 'addresses', 'duties', 'courses.department', 'departments', 'aliasAccounts', 'loadStatus', 'schools'])->firstOrFail();
        event(new AccountViewed($account));
        return $this->response->item($account, new AccountTransformer);
    }

    /**
     * Show Accounts with Load Status
     *
     * Show Accounts with the specified Load Status
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function showByLoadStatus(Request $request, $id)
    {
        $accounts = Account::where('load_status_id', $id)->paginate($this->resultLimit);
        event(new AccountsViewed($accounts->pluck('id')->toArray()));
        return $this->response->paginator($accounts, new AccountTransformer);
    }

    /**
     * Show Accounts with Load Status code
     *
     * Show Accounts with the specified Load Status code
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showByLoadStatusCode(Request $request, $code)
    {
        $ls = LoadStatus::where('code', $code)->firstOrFail();
        $accounts = Account::where('load_status_id', $ls->id)->paginate($this->resultLimit);
        event(new AccountsViewed($accounts->pluck('id')->toArray()));
        return $this->response->paginator($accounts, new AccountTransformer);
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
            'identifier' => 'alpha_num|required|max:7|min:6|unique:service_accounts,identifier',
            'name_prefix' => 'string|max:20',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:20',
            'name_phonetic' => 'string',
            'username' => 'string|required|min:3|unique:alias_accounts,username|unique:service_accounts,username',
            'expires_at' => 'date|after:now|nullable',
            'disabled' => 'boolean|nullable',
            'primary_duty_id' => 'integer|required_without:primary_duty_code|exists:duties,id,deleted_at,NULL',
            'primary_duty_code' => 'string|required_without:primary_duty_id|exists:duties,code,deleted_at,NULL',
            'load_status_id' => 'integer|exists:load_statuses,id,deleted_at,NULL',
            'load_status_code' => 'string|exists:load_statuses,code,deleted_at,NULL'
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

        // Convert the load_status_code to an id if needed
        if (array_key_exists('load_status_code', $data)) {
            $data['load_status_id'] = LoadStatus::where('code', $data['load_status_code'])->firstOrFail()->id;
        }

        // If the load status ID is not here at this point null it out.
        if (!array_key_exists('load_status_id', $data)) {
            $data['load_status_id'] = null;
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
                try {
                    if ($item->duties()->attach($data['primary_duty_id'])) {
                        event(new AssignedDuty($item, Duty::find($data['primary_duty_id'])));
                    }
                } catch (PDOException $exception) {
                    event(new AssignedDuty($item, Duty::find($data['primary_duty_id'])));
                    Log::notice('Failed to attach Account:' . $item->id . ' to Primary Duty: ' . $data['primary_duty_id'] . ' -- ' . $exception->getMessage() . ' -- ' . $exception->getTraceAsString());
                }
            } elseif ($item->wasRecentlyCreated) {
                try {
                    if ($item->duties()->attach($data['primary_duty_id'])) {
                        event(new AssignedDuty($item, Duty::find($data['primary_duty_id'])));
                    }
                } catch (PDOException $exception) {
                    event(new AssignedDuty($item, Duty::find($data['primary_duty_id'])));
                    Log::notice('Failed to attach Account:' . $item->id . ' to Primary Duty: ' . $data['primary_duty_id'] . ' -- ' . $exception->getMessage() . ' -- ' . $exception->getTraceAsString());
                }
            }
        }

        /**
         * Ugly but will prevent passwords from being set in future requests
         */
        $item->set_propagate_password();

        $trans = new AccountTransformer();
        $item = $trans->transform($item);
        return $this->response->created(route('api.accounts.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function patch(Request $request)
    {
        // Valid null strings
        $nulls = ['none', 'null', 'nil'];
        // Get the data as an array
        $data = $request->all();

        // Initial validator
        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required|max:7|min:6|unique:service_accounts,identifier',
            'name_prefix' => 'string|max:20',
            'name_first' => 'string|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|min:1',
            'name_postfix' => 'string|max:20',
            'name_phonetic' => 'string',
            'username' => 'string|min:3|unique:alias_accounts,username|unique:service_accounts,username',
            'expires_at' => 'date|after:now|nullable',
            'disabled' => 'boolean|nullable',
            'primary_duty_id' => 'integer|exists:duties,id,deleted_at,NULL',
            'primary_duty_code' => 'string|exists:duties,code,deleted_at,NULL',
            'load_status_id' => 'integer',
            'load_status_code' => 'string'
        ]);

        // Run an initial validation
        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());
        }

        // If we have the load_status_code
        if (array_key_exists('load_status_code', $data)) {
            // If the load status code 'none' or 'null' or 'nil'?
            if (in_array(strtolower($data['load_status_code']), $nulls, true)) {
                // Set the id to 0
                $data['load_status_id'] = 0;
                // Unset the code
                unset($data['load_status_code']);
            } else { // If the load status is not 'null' or 'none', or 'nil'
                // Create a validator
                $validator = Validator::make($data, ['load_status_code' => 'string|exists:load_statuses,code,deleted_at,NULL']);
                // Run validation
                if ($validator->fails()) {
                    throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());
                }
                // Se the load status id to the id of the object
                $data['load_status_id'] = LoadStatus::where('code', $data['load_status_code'])->firstOrFail()->id;
                // Unset the code
                unset($data['load_status_code']);
            }
        }

        // Do we have a load status ID?
        if (array_key_exists('load_status_id', $data)) {
            // Is it 0
            if ($data['load_status_id'] === 0) {
                // If so set it to null
                $data['load_status_id'] = null;
            } else { // If it is not 0
                // Create a validator
                $validator = Validator::make($data, ['load_status_id' => 'integer|exists:load_statuses,id,deleted_at,NULL']);
                // Run validation
                if ($validator->fails()) {
                    throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());
                }
            }
        }

        // Convert the load_status_code to an id if needed
        if (array_key_exists('primary_duty_code', $data)) {
            // Convert the duty code to an ID
            $data['primary_duty_id'] = Duty::where('code', $data['primary_duty_code'])->firstOrFail()->id;
            // Unset the code
            unset($data['primary_duty_code']);
        }

        // Don't pass the page param to the model
        if (array_key_exists('page', $data)) {
            unset($data['page']);
        }

        // Encrypt any sensitive information
        if (array_key_exists('ssn', $data)) $data['ssn'] = encrypt($data['ssn']);
        if (array_key_exists('password', $data)) $data['password'] = encrypt($data['password']);
        if (array_key_exists('birth_date', $data)) $data['birth_date'] = encrypt($data['birth_date']);

        // Get the account
        $item = Account::where(['identifier' => $data['identifier']]);
        // Create a new transformer
        $trans = new AccountTransformer();
        // Update the account
        $item->update($data);
        $item = $item->firstOrFail();
        // Fire the update event
        event(new AccountUpdated($item));
        /**
         * Ugly but will prevent passwords from being set in future requests
         */
        $item->set_propagate_password();
        // Get the updated account
        $item = $trans->transform($item);
        // Return a response
        return $this->response->created(route('api.accounts.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Account
     *
     * Deletes the specified Account by it's ID, Identifier, or Username attribute.
     *
     * @param Request $request
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

        try {
            $account->duties()->attach($data['duty_id']);
            event(new AssignedDuty($account, Duty::find($data['duty_id'])));
        } catch (PDOException $exception) {
            event(new AssignedDuty($account, Duty::find($data['duty_id'])));
            Log::notice('Failed to attach Account:' . $account->id . ' to Duty: ' . $data['duty_id'] . ' -- ' . $exception->getMessage() . ' -- ' . $exception->getTraceAsString());
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
     * Assign Account to School
     *
     * Creates the relationship between an Account and School.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function assignSchool(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:school_id|exists:schools,code,deleted_at,NULL',
            'school_id' => 'integer|required_without:code|exists:schools,id,deleted_at,NULL'
        ]);


        if ($validator->fails())
            throw new StoreResourceFailedException('Could not assign account to school.', $validator->errors());

        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new StoreResourceFailedException('Could not assign school to ' . $this->noun . '.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('school_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['school_id'] = School::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not assign school to ' . $this->noun . '.', ['You must supply a "school_id" or "code" parameter.']);
            }
        }

        try {
            $account->schools()->attach($data['school_id']);
            event(new AssignedSchool($account, School::find($data['school_id'])));
        } catch (PDOException $exception) {
            event(new AssignedSchool($account, School::find($data['school_id'])));
            Log::notice('Failed to attach Account:' . $account->id . ' to School: ' . $data['school_id'] . ' -- ' . $exception->getMessage() . ' -- ' . $exception->getTraceAsString());
        }

        return $this->response->created();
    }

    /**
     * Detach School from Account
     *
     * Destroys the relationship between an Account and School.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detachSchool(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:account_id,username|exists:accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:school_id|exists:schools,code,deleted_at,NULL',
            'school_id' => 'integer|required_without:code|exists:schools,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from school.', $validator->errors());


        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not detach ' . $this->noun . ' from school.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (!array_key_exists('school_id', $data)) {
            if (array_key_exists('code', $data)) {
                $data['school_id'] = School::where('code', $data['code'])->firstOrFail()->id;
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not detach ' . $this->noun . ' from school.', ['You must supply a "school_id" or "code" parameter.']);
            }
        }

        $account->schools()->detach($data['school_id']);

        //if ($account->courses()->detach($data['course_id'])) {
        event(new UnassignedSchool($account, School::find($data['school_id'])));
        //}
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

        try {
            $account->courses()->attach($data['course_id']);
            event(new AssignedCourse($account, Course::find($data['course_id'])));
        } catch (PDOException $exception) {
            event(new AssignedCourse($account, Course::find($data['course_id'])));
            Log::notice('Failed to attach Account:' . $account->id . ' to Course: ' . $data['course_id'] . ' -- ' . $exception->getMessage() . ' -- ' . $exception->getTraceAsString());
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

        $account->courses()->detach($data['course_id']);

        //if ($account->courses()->detach($data['course_id'])) {
        event(new UnassignedCourse($account, Course::find($data['course_id'])));
        //}
        return $this->destroySuccessResponse();
    }


    /**
     * Assign Account to Department
     *
     * Creates the relationship between an Account and Department.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
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

        try {
            $account->departments()->attach($data['department_id']);
            event($account, new AssignedDepartment($account, Department::find($data['department_id'])));
        } catch (PDOException $exception) {
            event($account, new AssignedDepartment($account, Department::find($data['department_id'])));
            Log::notice('Failed to attach Department:' . $account->id . ' to Department: ' . $data['department_id'] . ' -- ' . $exception->getMessage() . ' -- ' . $exception->getTraceAsString());
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

        $account->departments()->detach($data['department_id']);
        //if ($account->departments()->detach($data['department_id'])) {
        event($account, new UnassignedDepartment($account, Department::find($data['department_id'])));
        //}
        return $this->destroySuccessResponse();
    }


    /**
     * Assign Account to Room
     *
     * Creates the relationship between an Account and Room.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
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

        try {
            $account->rooms()->attach($data['room_id']);
            event($account, new AssignedRoom($account, Room::find($data['room_id'])));
        } catch (PDOException $exception) {
            event($account, new AssignedRoom($account, Room::find($data['room_id'])));
            Log::notice('Failed to attach Account:' . $account->id . ' to Room: ' . $data['room_id'] . ' -- ' . $exception->getMessage() . ' -- ' . $exception->getTraceAsString());
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

        $account->rooms()->detach($data['room_id']);

        //if ($account->rooms()->detach($data['room_id'])) {
        event($account, new UnassignedRoom($account, Room::find($data['room_id'])));
        //}
        return $this->destroySuccessResponse();
    }

}
