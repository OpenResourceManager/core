<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\MobilePhone;
use App\Http\Transformers\MobilePhoneTransformer;
use Illuminate\Http\Request;

class MobilePhoneController extends ApiController
{
    /**
     * Show all MobilePhones
     *
     * Get a paginated array of MobilePhones.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = MobilePhone::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new MobilePhoneTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
