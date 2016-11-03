<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Campus;
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
        return $this->response->paginator($accounts, new CampusController);
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
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
