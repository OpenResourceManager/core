<?php

namespace App\Http\Controllers;

use App\Model\Apikey;
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
     * @var string
     */
    protected $type = 'building';

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
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Building::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->buildingTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'campus_id' => 'integer|required|exists:campuses,id,deleted_at,NULL',
            'code' => 'string|required|max:10|min:3',
            'name' => 'string|required|max:30|min:3'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Building::updateOrCreate(['code' => Input::get('code')], Input::all());
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $result = Building::findOrFail($id);
        return $this->respondWithSuccess($this->buildingTransformer->transform($result));
    }

    /**
     * Display a resource with a specific code
     *
     * @param $code
     * @return mixed
     */
    public function showByCode(Request $request, $code)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $result = Building::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->buildingTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        //
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function destroy($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        Building::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeBuildingByCampusCode(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'campus_code' => 'string|required|exists:campuses,code,deleted_at,NULL',
            'code' => 'string|required|max:10|min:3',
            'name' => 'string|required|max:30|min:3'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $data = $request->all();
        $campus = Campus::where('code', $data['campus_code'])->firstOrFail();
        $item = Building::updateOrCreate(['code' => Input::get('code')], ['campus_id' => $campus->id, 'code' => $data['code'], 'name' => $data['name']]);
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);

    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function destroyByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        Building::where('code', $code)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function campusBuildings($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Campus::findOrFail($id)->buildings()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->buildingTransformer->transformCollection($result->all()));
    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function campusBuildingsByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Campus::where('code', $code)->firstOrFail()->buildings()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->buildingTransformer->transformCollection($result->all()));
    }
}
