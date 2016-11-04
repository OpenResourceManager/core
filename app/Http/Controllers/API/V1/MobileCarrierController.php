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
     * Show a MobileCarrier
     *
     * Display a Mobile Carrier by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = MobileCarrier::findOrFail($id);
        return $this->response->item($item, new MobileCarrierTransformer);
    }

    /**
     * Show MobileCarrier by Code
     *
     * Display a Mobile Carrier by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = MobileCarrier::where('code', $code)->firstOrFail();
        return $this->response->item($item, new MobileCarrierTransformer);
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
