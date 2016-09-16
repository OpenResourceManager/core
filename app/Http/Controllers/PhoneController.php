<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Phone;
use App\UUD\Transformers\PhoneTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class PhoneController extends ApiController
{
    /**
     * @var PhoneTransformer
     */
    protected $phoneTransformer;

    /**
     * @var string
     */
    protected $type = 'phone';

    /**
     * @param PhoneTransformer $phoneTransformer
     */
    function __construct(PhoneTransformer $phoneTransformer)
    {
        $this->phoneTransformer = $phoneTransformer;
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
        $result = Phone::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->phoneTransformer->transformCollection($result->all()));
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
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'number' => 'string|required|size:10',
            'country_code' => 'string|min:1|max:4',
            'ext' => 'string|max:5',
            'is_cell' => 'boolean|required',
            'mobile_carrier_id' => 'integer|required_if:is_cell,true|exists:mobile_carriers,id,deleted_at,NULL',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());

        $phone = Phone::onlyTrashed()->where(['number' => Input::get('number')])->get()->first();
        if ($phone) $phone->restore();

        $item = Phone::updateOrCreate(['number' => Input::get('number')], Input::all());
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $result = Phone::findOrFail($id);
        return $this->respondWithSuccess($this->phoneTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        Phone::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userPhones($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->phones()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->phoneTransformer->transformCollection($result->all()));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return mixed
     */
    public function userPhonesByIdentifier($identifier, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('identifier', $identifier)->firstOrFail()->phones()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->phoneTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userPhonesByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->phones()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->phoneTransformer->transformCollection($result->all()));
    }
}
