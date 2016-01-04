<?php

namespace App\Http\Controllers;

use App\Model\Email;
use App\Model\User;
use App\UUD\Transformers\EmailTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class EmailController extends ApiController
{
    /**
     * @var EmailTransformer
     */
    protected $emailTransformer;

    /**
     * @param EmailTransformer $emailTransformer
     */
    function __construct(EmailTransformer $emailTransformer)
    {
        $this->emailTransformer = $emailTransformer;
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
        $result = Email::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
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
            'user_id' => 'integer|required|exists:users,id,deleted_at,NULL',
            'email' => 'email|required|unique:emails,deleted_at,NULL',

        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        $item = Email::updateOrCreate(['email' => Input::get('email')], Input::all());
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
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = Email::findOrFail($id);
        return $this->respondWithSuccess($this->emailTransformer->transform($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
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
    public function destroy(Request $request, $id)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        Email::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userEmails($id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::findOrFail($id)->emails()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }

    /**
     * @param $user_id
     * @param Request $request
     * @return mixed
     */
    public function userEmailsByUserId($user_id, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::where('user_identifier', $user_id)->firstOrFail()->emails()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userEmailsByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        $result = User::where('username', $username)->firstOrFail()->emails()->paginate();
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }
}
