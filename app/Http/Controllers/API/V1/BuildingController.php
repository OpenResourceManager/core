<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Building;
use App\Http\Transformers\BuildingTransformer;
use Illuminate\Http\Request;

class BuildingController extends ApiController
{
    /**
     * Show all Buildings
     *
     * Get a paginated array of Buildings.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Building::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new BuildingTransformer);
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
