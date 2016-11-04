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
     * Show a State
     *
     * Display a State by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = State::findOrFail($id);
        return $this->response->item($item, new StateTransformer);
    }

    /**
     * Show State by Code
     *
     * Display a State by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = State::where('code', $code)->firstOrFail();
        return $this->response->item($item, new StateTransformer);
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
