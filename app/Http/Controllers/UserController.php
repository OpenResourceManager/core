<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\Building;
use App\Model\Campus;
use App\Model\Course;
use App\Model\Role;
use App\Model\User;
use App\UUD\Transformers\UserTransformer;
use Illuminate\Http\Request;
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_identifier' => 'string|required|max:7|min:6',
            'name_prefix' => 'string|max:7',
            'name_first' => 'string|required|min:1',
            'name_middle' => 'string',
            'name_last' => 'string|required|min:1',
            'name_postfix' => 'string|max:7',
            'name_phonetic' => 'string',
            'username' => 'string|required|min:3|unique:users,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = User::updateOrCreate(['user_identifier' => Input::get('user_identifier')], Input::all());
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::findOrFail($id);
        return $this->respondWithSuccess($this->userTransformer->transform($result));
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function showByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::where('user_identifier', $user_id)->firstOrFail();
        return $this->respondWithSuccess($this->userTransformer->transform($result));
    }

    /**
     * @param $username
     * @return mixed
     */
    public function showByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::where('username', $username)->firstOrFail();
        return $this->respondWithSuccess($this->userTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        User::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroyByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        User::where('user_identifier', $user_id)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $username
     * @return \Illuminate\Http\Response
     */
    public function destroyByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        User::where('username', $username)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function campusUsers($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Campus::findOrFail($id)->users();
        return $this->respondWithSuccess($this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function buildingUsers($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Building::findOrFail($id)->users();

       // echo json_encode($result);

        return $this->respondWithSuccess($this->userTransformer->transformCollection($result));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function buildingUsersByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Building::where('code', $code)->firstOrFail()->users();

        echo json_encode($result);

        //  return $this->respondWithSuccess($this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function roleUsers($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Role::findOrFail($id)->users()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function roleUsersByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Role::where('code', $code)->firstOrFail()->users()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function courseUsers($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Course::findOrFail($id)->users()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }

    /**
     * @param $code
     * @param Request $request
     * @return mixed
     */
    public function courseUsersByCode($code, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Course::where('code', $code)->firstOrFail()->users()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->userTransformer->transformCollection($result->all()));
    }
}
