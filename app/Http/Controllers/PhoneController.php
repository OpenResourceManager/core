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
        parent::index($request);
        $result = Phone::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->phoneTransformer->transformCollection($result->all()));
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
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'number' => 'integer|required|max:11',
            'ext' => 'integer|max:5',
            'is_cell' => 'boolean|required',
            'carrier' => 'string|max:20',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Phone::create(Input::all());
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
        $result = Phone::findOrFail($id);
        return $this->respondWithSuccess($this->phoneTransformer->transform($result));
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
        Phone::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userPhones($id, Request $request)
    {
        $result = User::findOrFail($id)->phones()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->phoneTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userPhonesByUserId($user_id, Request $request)
    {
        $result = User::where('user_identifier', $user_id)->firstOrFail()->phones()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->phoneTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userPhonesByUsername($username, Request $request)
    {
        $result = User::where('username', $username)->firstOrFail()->phones()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->phoneTransformer->transformCollection($result->all()));
    }
}
