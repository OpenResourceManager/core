<?php

namespace App\Http\Controllers;

use App\Model\Record\User_Record;
use App\UUD\Transformers\UserRecordTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;

class UserRecordController extends ApiController
{

    /**
     * @var \App\UUD\Transformers\UserRecordTransformer
     */
    protected $userRecordTransformer;

    /**
     * @param UserRecordTransformer $userRecordTransformer
     */
    function __construct(UserRecordTransformer $userRecordTransformer)
    {
        $this->userRecordTransformer = $userRecordTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = User_Record::all();
        return $this->respondWithSuccess($this->userRecordTransformer->transformCollection($result->all()));
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
            'active' => 'boolean|required',
            'sageid' => 'string|required|max:7|min:6|unique:user_records,deleted_at,NULL',
            'name_prefix' => 'string|max:7',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:7',
            'name_phonetic' => 'string',
            'username' => 'string|required|max:11|min:3|unique:user_records,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        User_Record::create(Input::all());
        return $this->respondCreateSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = User_Record::find($id);
        if (!$result) return $this->respondNotFound();
        return $this->respondWithSuccess($this->userRecordTransformer->transform($result));
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
        //
    }
}
