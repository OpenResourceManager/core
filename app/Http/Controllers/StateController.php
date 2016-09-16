<?php

namespace App\Http\Controllers;

use App\Model\State;
use App\UUD\Transformers\StateTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class StateController extends ApiController
{

    /**
     * @var StateTransformer
     */
    protected $stateTransformer;

    /**
     * @var string
     */
    protected $type = 'state';

    /**
     * StateController constructor.
     * @param StateTransformer $stateTransformer
     */
    function __construct(StateTransformer $stateTransformer)
    {
        $this->stateTransformer = $stateTransformer;
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
        $result = State::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->stateTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
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
            'country_id' => 'integer|required|exists:campuses,id,deleted_at,NULL',
            'code' => 'string|required|max:5|unique:states,deleted_at,NULL',
            'name' => 'string|required|max:50'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        State::where('code', Input::get('code'))->onlyTrashed()->restore();
        $item = State::updateOrCreate(['code' => Input::get('code')], Input::all());
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
        $result = State::findOrFail($id);
        return $this->respondWithSuccess($this->stateTransformer->transform($result));
    }

    /**
     * @param Request $request
     * @param $code
     * @return mixed
     */
    public function showByCode(Request $request, $code)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $result = State::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->stateTransformer->transform($result));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        State::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function destroyByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        State::where('code', $code)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }
}
