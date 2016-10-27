<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;
use App\Http\Transformers\AccountTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

/**
 * Class AccountController
 * @package App\Http\Controllers\API\V1
 * @Resource("Accounts", uri="/accounts")
 */
class AccountController extends ApiController
{
    /**
     * Show all accounts
     *
     * Get a paginated array of accounts.
     *
     * @return \Dingo\Api\Http\Response
     *
     * @Get("/")
     */
    public function index()
    {
        $accounts = Account::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new AccountTransformer);
    }

    /**
     * Select account by `id`
     *
     * View a single account by providing it's primary key.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     *
     * @Get("/{id}")
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);
        return $this->response->item($account, new AccountTransformer);
    }

    /**
     * Select account by `username`
     *
     * View a single account by providing it's username.
     *
     * @param $username
     * @return \Dingo\Api\Http\Response
     *
     * @Get("/username/{username}")
     */
    public function showFromUsername($username)
    {
        $account = Account::where('username', $username)->firstOrFail();
        return $this->response->item($account, new AccountTransformer);
    }

    /**
     * Select account by `identifier`
     *
     * View a single account by providing it's identifier.
     *
     * @param $identifier
     * @return \Dingo\Api\Http\Response
     *
     * @Get("/identifier/{identifier}")
     */
    public function showFromIdentifier($identifier)
    {
        $account = Account::where('identifier', $identifier)->firstOrFail();
        return $this->response->item($account, new AccountTransformer);
    }

    /**
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     *
     * @Post("/")
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
            'primary_duty_code' => 'string|exists:duties,code,deleted_at,NULL',
            'waiting_for_password' => 'boolean|required',
        ]);
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store account.', $validator->errors());
        }

        if (!empty(Input::get('primary_duty_code'))) {
            $duty = Duty::where('code', Input::get('primary_duty_code'))->firstOrFail();
            $account['primary_duty'] = $duty->id;
        } else if (!empty(Input::get('primary_duty'))) {
            $duty = Duty::findOrFail(Input::get('primary_duty'));
            $account['primary_duty'] = $duty->id;
        } else {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not store account.', ['Neither a "primary_duty_code" or "primary_duty" value was provided.']);
        }
        // If the account is trashed restore them first.
        if ($accountToRestore = Account::onlyTrashed()->where('identifier', $data['identifier'])->first()) {
            $accountToRestore->restore();
            $restore_account = Account::where('identifier', $data['identifier'])->first();
        }
        $item = Account::updateOrCreate(['identifier' => Input::get('identifier')], $account);

        if (!empty($restore_account) && !$item->wasRecentlyCreated) {
            if ($account['primary_duty'] !== $restore_account->primary_duty) {
                // Broadcast with redis to notify the event server
                $item->duties()->detach($restore_account->primary_duty);
                $item->duties()->attach($account['primary_duty']);
            } elseif ($item->wasRecentlyCreated) {
                $item->duties()->attach($account['primary_duty']);
            }
        }

        return $this->response->created(route('api.accounts.show', ['id' => $item->id]), $item);
    }


    /**
     * @param $id
     * @return mixed
     *
     * @Delete("/{id}")
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);

        return ($account->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure('account');
    }

    /**
     * @param $username
     * @return mixed
     *
     * @Delete("/username/{username}")
     */
    public function destroyFromUsername($username)
    {
        $account = Account::where('username', $username)->firstOrFail();

        return ($account->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure('account');
    }

    /**
     * @param $identifier
     * @return mixed
     *
     * @Delete("/identifier/{identifier}")
     */
    public function destroyIdentifier($identifier)
    {
        $account = Account::where('identifier', $identifier)->firstOrFail();

        return ($account->delete()) ? $this->destroySuccessResponse() : $this->destroyFailure('account');
    }
}
