<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;
use App\Http\Transformers\AccountTransformer;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;


class AccountController extends ApiController
{
    /**
     * Show all Accounts
     *
     * Get a paginated array of Accounts.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Account::paginate($this->resultLimit);
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
        $account = Account::findOrFail($id);
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
        $account = Account::where('username', $username)->firstOrFail();
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
        $account = Account::where('identifier', $identifier)->firstOrFail();
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
            'identifier' => 'alpha_num|required|max:7|min:6|unique:accounts,deleted_at,NULL',
            'name_prefix' => 'string|max:20',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:20',
            'name_phonetic' => 'string',
            'username' => 'string|required|min:3|unique:accounts,deleted_at,NULL',
            'primary_duty' => 'integer',
            'primary_duty_code' => 'string|exists:duties,code,deleted_at,NULL'
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not store account.', $validator->errors());
        }

        if (!empty(Input::get('primary_duty_code'))) {
            $duty = Duty::where('code', Input::get('primary_duty_code'))->firstOrFail();
            $account['primary_duty'] = $duty->id;
        } else if (!empty(Input::get('primary_duty'))) {
            $duty = Duty::findOrFail(Input::get('primary_duty'));
            $account['primary_duty'] = $duty->id;
        } else {
            throw new StoreResourceFailedException('Could not store account.', ['Neither a "primary_duty_code" or "primary_duty" value was provided.']);
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
            'identifier' => 'alpha_num|required_without_all:account_id,username|max:7|min:6|exists:accounts,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|min:3|exists:accounts,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|min:1|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:duty_id|min:3|exists:duties,deleted_at,NULL',
            'duty_id' => 'integer|required_without:code|min:1|exists:duties,id,deleted_at,NULL'
        ]);

        /*
         * @todo Fix validator, right now it is causing: "Undefined offset: 1" error
        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not assign duty to account.', $validator->errors());
        }
        */

        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new StoreResourceFailedException('Could not assign duty to account.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (array_key_exists('duty_id', $data)) {
            $duty = Duty::findOrFail($data['duty_id']);
        } elseif (array_key_exists('code', $data)) {
            $duty = Duty::where('code', $data['code'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new StoreResourceFailedException('Could not assign duty to account.', ['You must supply a "duty_id" or "code" parameter.']);
        }

        $account->duties()->attach($duty->id);

        return $this->response->created();
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
            'identifier' => 'alpha_num|required_without_all:id,username|max:7|min:6|exists:accounts,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,id|min:3|exists:accounts,deleted_at,NULL',
            'id' => 'integer|required_without_all:identifier,username|min:1|exists:accounts,deleted_at,NULL'
        ]);

        /*
         * @todo Fix validator, right now it is causing: "Undefined offset: 1" error
        if ($validator->fails()) {
             throw new DeleteResourceFailedException('Could not destroy account.', $validator->errors()->all());
         } */

        if (array_key_exists('id', $data)) {
            $account = Account::findOrFail($data['id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not destroy account.', ['You must supply one of the following fields "id", "identifier", or "username".']);
        }

        return ($account->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure('account');
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
            'identifier' => 'alpha_num|required_without_all:account_id,username|max:7|min:6|exists:accounts,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,account_id|min:3|exists:accounts,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:identifier,username|min:1|exists:accounts,id,deleted_at,NULL',
            'code' => 'string|required_without:duty_id|min:3|exists:duties,deleted_at,NULL',
            'duty_id' => 'integer|required_without:code|min:1|exists:duties,id,deleted_at,NULL'
        ]);

        /*
         * @todo Fix validator, right now it is causing: "Undefined offset: 1" error
        if ($validator->fails()) throw new DeleteResourceFailedException('Could not destroy account.', $validator->errors());
        */

        if (array_key_exists('account_id', $data)) {
            $account = Account::findOrFail($data['account_id']);
        } elseif (array_key_exists('identifier', $data)) {
            $account = Account::where('identifier', $data['identifier'])->firstOrFail();
        } elseif (array_key_exists('username', $data)) {
            $account = Account::where('username', $data['username'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not detach account from duty.', ['You must supply one of the following parameters "account_id", "identifier", or "username".']);
        }

        if (array_key_exists('duty_id', $data)) {
            $duty = Duty::findOrFail($data['duty_id']);
        } elseif (array_key_exists('code', $data)) {
            $duty = Duty::where('code', $data['code'])->firstOrFail();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not detach account from duty.', ['You must supply a "duty_id" or "code" parameter.']);
        }

        $account->duties()->detach($duty->id);

        if ($duty->id === $account->primary_duty) {
            $account->primary_duty = null;
            $account->save();
        }

        return $this->destroySuccessResponse();
    }
}
