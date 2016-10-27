<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Account;
use App\Http\Transformers\AccountTransformer;
use Dingo\Api\Facade\API;

class AccountController extends ApiController
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $user = API::user();

        $accounts = Account::paginate($this->resultLimit);

        return $this->response->paginator($accounts, new AccountTransformer);
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $account = Account::findOrFail($id);

        return $this->response->item($account, new AccountTransformer);
    }
}
