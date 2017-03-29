<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\AliasAccount;
use App\Http\Transformers\AliasAccountTransformer;
use Illuminate\Http\Request;
use Dingo\Api\Exception\StoreResourceFailedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Validator;
use App\Models\Access\Permission\Permission;
use App\Http\Models\API\Account;
use Dingo\Api\Exception\DeleteResourceFailedException;
use App\Events\Api\AliasAccount\AliasAccountViewed;
use App\Events\Api\AliasAccount\AliasAccountsViewed;

class AliasAccountController extends ApiController
{

    /**
     * AliasAccountController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'alias account';
    }

    /**
     * Show all Alias Accounts
     *
     * Get a paginated array of Alias Accounts.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $alias_accounts = AliasAccount::paginate($this->resultLimit);
        event(new AliasAccountsViewed($alias_accounts->pluck('id')->toArray()));
        return $this->response->paginator($alias_accounts, new AliasAccountTransformer);
    }

    /**
     * Select Alias Account by ID
     *
     * View a single Alias Account by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $alias_account = AliasAccount::findOrFail($id);
        event(new AliasAccountViewed($alias_account));
        return $this->response->item($alias_account, new AliasAccountTransformer);
    }

    /**
     * Select Alias Account by Username
     *
     * View a single Alias Account by providing it's Username attribute.
     *
     * @param $username
     * @return \Dingo\Api\Http\Response
     */
    public function showFromUsername($username)
    {
        $alias_account = AliasAccount::where('username', $username)->firstOrFail();
        event(new AliasAccountViewed($alias_account));
        return $this->response->item($alias_account, new AliasAccountTransformer);
    }

    /**
     * Select Alias Account by Identifier
     *
     * View a single Alias Account by providing it's Identifier attribute.
     *
     * @param $identifier
     * @return \Dingo\Api\Http\Response
     */
    public function showFromIdentifier($identifier)
    {
        $alias_account = AliasAccount::where('identifier', $identifier)->firstOrFail();
        event(new AliasAccountViewed($alias_account));
        return $this->response->item($alias_account, new AliasAccountTransformer);
    }

    /**
     * Store/Save/Restore Alias Account
     *
     * Create or update Alias Account information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (array_key_exists('password', $data)) {
            $user = auth()->user();
            if ($user->hasPermission(Permission::where('name', 'write-alias-classified')->firstOrFail())) {
                $classifiedValidator = Validator::make($data, [
                    'password' => 'string|min:6|nullable',
                    'should_propagate_password' => 'boolean|nullable',
                ]);
                if ($classifiedValidator->fails()) {
                    throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $classifiedValidator->errors());
                }
            } else {
                throw new UnauthorizedHttpException('You are not authorized to write classified information. Hint: request greater access or remove any references `password` in your data.');
            }
            if (array_key_exists('password', $data)) $data['password'] = encrypt($data['password']);
        }

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required|max:12|min:3',
            'username' => 'string|required|min:3',
            'account_identifier' => 'alpha_num|required_without_all:account_id,account_username|max:7|min:6|exists:accounts,identifier,deleted_at,NULL',
            'account_username' => 'string|required_without_all:account_identifier,account_id|min:3|exists:accounts,username,deleted_at,NULL',
            'account_id' => 'integer|required_without_all:account_identifier,account_username|min:1|exists:accounts,id,deleted_at,NULL',
            'expires_at' => 'date|after:now|nullable',
            'disabled' => 'boolean|nullable'
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not store ' . $this->noun . '.', $validator->errors());
        }

        /**
         * Translate account account_identifier or account_username to an account_id if needed
         */
        if (!array_key_exists('account_id', $data)) {
            if (array_key_exists('account_identifier', $data)) {
                $account = Account::where('identifier', $data['account_identifier'])->firstOrFail();
            } elseif (array_key_exists('username', $data)) {
                $account = Account::where('username', $data['account_username'])->firstOrFail();
            } else {
                // The validator should throw something like this, but it's here just in case.
                throw new StoreResourceFailedException('Could not store ' . $this->noun, ['You must supply one of the following parameters "account_id", "account_identifier", or "account_username".']);
            }
            $data['account_id'] = $account->id;
        }

        // If the account is trashed restore them first.
        if ($accountToRestore = AliasAccount::onlyTrashed()->where('identifier', $data['identifier'])->first()) $accountToRestore->restore();

        $item = AliasAccount::updateOrCreate(['identifier' => $data['identifier']], $data);

        $trans = new AliasAccountTransformer();
        $item = $trans->transform($item);
        return $this->response->created(route('api.accounts.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Alias Account
     *
     * Deletes the specified Alias Account by it's ID, Identifier, or Username attribute.
     *
     * @return mixed
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'identifier' => 'alpha_num|required_without_all:id,username|exists:alias_accounts,identifier,deleted_at,NULL',
            'username' => 'string|required_without_all:identifier,id|exists:alias_accounts,username,deleted_at,NULL',
            'id' => 'integer|required_without_all:identifier,username|exists:alias_accounts,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not destroy alias account.', $validator->errors()->all());

        if (array_key_exists('id', $data)) {
            $deleted = AliasAccount::destroy($data['id']);
        } elseif (array_key_exists('identifier', $data)) {
            $deleted = AliasAccount::where('identifier', $data['identifier'])->firstOrFail()->delete();
        } elseif (array_key_exists('username', $data)) {
            $deleted = AliasAccount::where('username', $data['username'])->firstOrFail()->delete();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', ['You must supply one of the following fields "id", "identifier", or "username".']);
        }

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure('account');
    }
}
