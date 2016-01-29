<?php

namespace App\Http\Controllers;

use App\Model\MobileCarrier;
use App\UUD\Transformers\MobileCarrierTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class MobileCarrierController extends ApiController
{


    /**
     * @var MobileCarrierTransformer
     */
    protected $mobileCarrierTransformer;

    /**
     * @var string
     */
    protected $type = 'mobile_carrier';

    /**
     * MobileCarrierController constructor.
     * @param MobileCarrierTransformer $mobileCarrierTransformer
     */
    function __construct(MobileCarrierTransformer $mobileCarrierTransformer)
    {
        $this->mobileCarrierTransformer = $mobileCarrierTransformer;
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
        $result = MobileCarrier::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->mobileCarrierTransformer->transformCollection($result->all()));
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
            'code' => 'string|required||min:3|unique:mobile_carriers,deleted_at,NULL',
            'name' => 'string|required|min:3',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = MobileCarrier::updateOrCreate(['code' => Input::get('code')], Input::all());
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
        $result = MobileCarrier::findOrFail($id);
        return $this->respondWithSuccess($this->mobileCarrierTransformer->transform($result));
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
        $result = MobileCarrier::where('code', $code)->firstOrFail();
        return $this->respondWithSuccess($this->mobileCarrierTransformer->transform($result));
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
        MobileCarrier::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $code
     * @return \Illuminate\Http\Response
     */
    public function destroyByCode(Request $request, $code)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        MobileCarrier::where('code', $code)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }
}
