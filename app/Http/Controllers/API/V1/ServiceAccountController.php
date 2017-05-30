<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\ServiceAccount;
use App\Http\Transformers\ServiceAccountTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Access\Permission\Permission;
use App\Http\Models\API\Account;
use Dingo\Api\Exception\DeleteResourceFailedException;
use Dingo\Api\Exception\StoreResourceFailedException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Events\Api\ServiceAccount\ServiceAccountsViewed;
use App\Events\Api\ServiceAccount\ServiceAccountViewed;

class ServiceAccountController extends ApiController
{
    /**
     * ServiceAccountController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->noun = 'service account';
    }

    /**
     * Show all Service Accounts
     *
     * Get a paginated array of Service Accounts.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $service_accounts = ServiceAccount::paginate($this->resultLimit);
        event(new ServiceAccountsViewed($service_accounts->pluck('id')->toArray()));
        return $this->response->paginator($service_accounts, new ServiceAccountTransformer);
    }

    /**
     * Select Service Account by ID
     *
     * View a single Service Account by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $account = ServiceAccount::findOrFail($id);
        event(new ServiceAccountViewed($account));
        return $this->response->item($account, new ServiceAccountTransformer);
    }

    /**
     * Select Service Account by Username
     *
     * View a single Service Account by providing it's Username attribute.
     *
     * @param $username
     * @return \Dingo\Api\Http\Response
     */
    public function showFromUsername($username)
    {
        $service_account = ServiceAccount::where('username', $username)->firstOrFail();
        event(new ServiceAccountViewed($service_account));
        return $this->response->item($service_account, new ServiceAccountTransformer);
    }

    /**
     * Select Service Account by Identifier
     *
     * View a single Service Account by providing it's Identifier attribute.
     *
     * @param $identifier
     * @return \Dingo\Api\Http\Response
     */
    public function showFromIdentifier($identifier)
    {
        $service_account = ServiceAccount::where('identifier', $identifier)->firstOrFail();
        event(new ServiceAccountViewed($service_account));
        return $this->response->item($service_account, new ServiceAccountTransformer);
    }

    /**
     * Store/Save/Restore Service Account
     *
     * Create or update Service Account information.
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (array_key_exists('password', $data)) {
            $user = auth()->user();
            if ($user->hasPermission(Permission::where('name', 'write-service-classified')->firstOrFail())) {
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
            'username' => 'string|required|min:3|unique:accounts,username|unique:alias_accounts,username',
            'identifier' => 'alpha_num|required|max:7|min:6|unique:accounts,identifier',
            'name_first' => 'string|required|min:1',
            'name_last' => 'string|required|min:1',
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
        if ($accountToRestore = ServiceAccount::onlyTrashed()->where('identifier', $data['identifier'])->first()) {
            $accountToRestore->restore();
        }

        $item = ServiceAccount::updateOrCreate(['identifier' => $data['identifier']], $data);

        $trans = new ServiceAccountTransformer();
        $item = $trans->transform($item);
        return $this->response->created(route('api.service-accounts.show', ['id' => $item['id']]), ['data' => $item]);
    }

    /**
     * Destroy Service Account
     *
     * Deletes the specified Service Account by it's ID, Identifier, or Username attribute.
     *
     * @return mixed
     */
    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'string|required_without_all:id,identifier|exists:service_accounts,username,deleted_at,NULL',
            'identifier' => 'string|required_without_all:id,username|exists:service_accounts,identifier,deleted_at,NULL',
            'id' => 'integer|required_without_all:username,identifier|exists:service_accounts,id,deleted_at,NULL'
        ]);

        if ($validator->fails())
            throw new DeleteResourceFailedException('Could not destroy alias account.', $validator->errors()->all());

        if (array_key_exists('id', $data)) {
            $deleted = ServiceAccount::destroy($data['id']);
        } elseif (array_key_exists('username', $data)) {
            $deleted = ServiceAccount::where('username', $data['username'])->firstOrFail()->delete();
        } elseif (array_key_exists('identifier', $data)) {
            $deleted = ServiceAccount::where('identifier', $data['identifier'])->firstOrFail()->delete();
        } else {
            // The validator should throw something like this, but it's here just in case.
            throw new DeleteResourceFailedException('Could not destroy ' . $this->noun . '.', ['You must supply one of the following fields "id", "identifier", or "username".']);
        }

        return ($deleted) ? $this->destroySuccessResponse() : $this->destroyFailure('service account');
    }
}
