<?php

namespace App\Http\Controllers;

use App\Model\Building;
use App\Model\Campus;
use App\UUD\Transformers\BuildingTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class BuildingController extends ApiController
{

    /**
     * @var BuildingTransformer
     */
    protected $buildingTransformer;

    /**
     * @param BuildingTransformer $buildingTransformer
     */
    function __construct(BuildingTransformer $buildingTransformer)
    {
        $this->buildingTransformer = $buildingTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        parent::index($request);
        $result = Building::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->buildingTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'campus_id' => 'integer|required|exists:campuses,id,deleted_at,NULL',
            'code' => 'string|required|max:10|min:3|unique:campuses,deleted_at,NULL',
            'name' => 'string|required|max:30|min:3'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Building::create(Input::all());
        return $this->respondCreateSuccess($id = $item->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Building::findOrFail($id);
        return $this->respondWithSuccess($this->buildingTransformer->transform($result));
    }

    /**
     * Display a resource with a specific code
     *
     * @param $code
     * @return mixed
     */
    public function showByCode($code)
    {
        $result = Building::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->buildingTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
        Building::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function destroyByCode($code)
    {
        Building::where('code', $code)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function campusBuildings($id, Request $request)
    {
        $result = Campus::findOrFail($id)->buildings()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->buildingTransformer->transformCollection($result->all()));
    }

}
