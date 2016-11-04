<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Address;
use App\Http\Transformers\AddressTransformer;
use Illuminate\Http\Request;

class AddressController extends ApiController
{
    /**
     * Show all Addresses
     *
     * Get a paginated array of Addresses.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Address::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new AddressTransformer);
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
