<?php namespace App\Http\Controllers;

use App\Model\User;
use App\Model\BirthDate;
use App\UUD\Transformers\BirthDateTransformer;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 3/1/16
 * Time: 12:48 PM
 */
class BirthDateController extends ApiController
{

    /**
     * @var BirthDateTransformer
     */
    protected $birthDateTransformer;

    /**
     * @var string
     */
    protected $type = 'birth_date';

    /**
     * BirthDateController constructor.
     * @param BirthDateTransformer $birthDateTransformer
     */
    function __construct(BirthDateTransformer $birthDateTransformer)
    {
        $this->birthDateTransformer = $birthDateTransformer;
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
        $result = BirthDate::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->birthDateTransformer->transformCollection($result->all()));
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
            'birth_date' => 'date|required',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $date = date('Y-m-d', strtotime(Input::get('birth_date')));
        $item = BirthDate::updateOrCreate(['user_id' => Input::get('user_id')], ['user_id' => Input::get('user_id'), 'birth_date' => $date]);
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
        $result = BirthDate::findOrFail($id);
        return $this->respondWithSuccess($this->birthDateTransformer->transform($result));
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
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        BirthDate::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userBirthDates($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->birth_date()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->birthDateTransformer->transformCollection($result->all()));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return mixed
     */
    public function userBirthDatesByIdentifier($identifier, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('identifier', $identifier)->firstOrFail()->birth_date()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->birthDateTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userBirthDatesByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->birth_date()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->birthDateTransformer->transformCollection($result->all()));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeUserBirthDateByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'birth_date' => 'date|required',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $date = date('Y-m-d', strtotime(Input::get('birth_date')));
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        $item = BirthDate::updateOrCreate(['user_id' => $user->id], ['user_id' => $user->id, 'birth_date' => $date]);
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeUserBirthDateByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'birth_date' => 'date|required',
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $date = date('Y-m-d', strtotime(Input::get('birth_date')));
        $user = User::where('username', $request->input('username'))->firstOrFail();
        $item = BirthDate::updateOrCreate(['user_id' => $user->id], ['user_id' => $user->id, 'birth_date' => $date]);
        return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteUserBirthDate(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::findOrFail($request->input('user_id'));
        BirthDate::where('user_id', $user->id)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteUserBirthDateByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        BirthDate::where('user_id', $user->id)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteUserBirthDateByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $user = User::where('username', $request->input('username'))->firstOrFail();
        BirthDate::where('user_id', $user->id)->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

}