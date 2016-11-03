<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\State;
use App\Http\Transformers\StateTransformer;
use Illuminate\Http\Request;

class StateController extends ApiController
{
    /**
     * Show all States
     *
     * Get a paginated array of States.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = State::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new StateTransformer);
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
