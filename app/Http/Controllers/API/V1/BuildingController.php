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
     * Show a Building
     *
     * Display a Building by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Building::findOrFail($id);
        return $this->response->item($item, new BuildingTransformer);
    }

    /**
     * Show Building by Code
     *
     * Display a Building by providing it's Code attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromCode($code)
    {
        $item = Building::where('code', $code)->firstOrFail();
        return $this->response->item($item, new BuildingTransformer);
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
