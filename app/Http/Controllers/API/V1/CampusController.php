<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Campus;
use App\Http\Transformers\CampusTransformer;
use Illuminate\Http\Request;

class CampusController extends ApiController
{
    /**
     * Show all Campuses
     *
     * Get a paginated array of Campuses.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Campus::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new CampusTransformer);
    }

    /**
     * Show a Campus
     *
     * Display a Campus by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Campus::findOrFail($id);
        return $this->response->item($item, new CampusTransformer);
    }

    /**
     * Show Campus by Code
     *
     * Display a Campus by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Campus::where('code', $code)->firstOrFail();
        return $this->response->item($item, new CampusTransformer);
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
