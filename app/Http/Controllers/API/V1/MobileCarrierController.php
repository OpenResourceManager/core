<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\MobileCarrier;
use App\Http\Transformers\MobileCarrierTransformer;
use Illuminate\Http\Request;

class MobileCarrierController extends ApiController
{
    /**
     * Show all MobileCarriers
     *
     * Get a paginated array of MobileCarriers.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = MobileCarrier::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new MobileCarrierTransformer);
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
