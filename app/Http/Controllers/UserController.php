<?php

namespace App\Http\Controllers;

use App\Model\Building;
use App\Model\Campus;
use App\Model\Course;
use App\Model\User;
use App\UUD\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends ApiController
{

    /**
     * @var UserTransformer
     */
    protected $userTransformer;

    /**
     * @param UserTransformer $userTransformer
     */
    function __construct(UserTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        parent::index($request);
        $result = User::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
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
            'user_identifier' => 'string|required|max:7|min:6|unique:users,deleted_at,NULL',
            'name_prefix' => 'string|max:7',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:7',
            'name_phonetic' => 'string',
            'username' => 'string|required|min:3|unique:users,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = User::create(Input::all());
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
        $result = User::findOrFail($id);
        $result->email = $result->emails;
        $result->phone = $result->phones;
        $result->room = $result->rooms;
        $result->course = $result->courses;
        return $this->respondWithSuccess($this->userTransformer->transform($result));
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function showByUserId($user_id)
    {
        $result = User::where('user_identifier', $user_id)->firstOrFail()->emails()->rooms()->courses();
        return $this->respondWithSuccess($this->userTransformer->transform($result));
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

    /**
     * @param $id
     * @return mixed
     */
    public function campusUsers($id)
    {
        $result = Campus::findOrFail($id)->users();
        return $this->respondWithSuccess($this->userTransformer->transformCollection($result));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function buildingUsers($id)
    {
        $result = Building::findOrFail($id)->users();
        return $this->respondWithSuccess($this->userTransformer->transformCollection($result));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseUsers($id, Request $request)
    {
        $result = Course::findOrFail($id)->users()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }
}
