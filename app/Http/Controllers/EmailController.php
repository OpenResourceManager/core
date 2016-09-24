<?php

namespace App\Http\Controllers;

use App\Model\Email;
use App\Model\User;
use App\UUD\Transformers\EmailTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\UUD\Helper;

class EmailController extends ApiController
{
    /**
     * @var EmailTransformer
     */
    protected $emailTransformer;

    /**
     * @var string
     */
    protected $type = 'email';

    /**
     * EmailController constructor.
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
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
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
            'email' => 'email|required|unique:emails,deleted_at,NULL',
            'verified' => 'boolean',
            //'verification_token' => 'string|max:6|min:3|unique:emails,deleted_at,NULL|unique:phones,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        // Get an array of excluded email domains
        $excluded_domains = explode(',', env('EMAIL_MODEL_EXCLUDE_DOMAINS', ''));
        $email_parts = explode('@', Input::get('email'));
        if (in_array($email_parts[1], $excluded_domains)) return $this->respondUnprocessableEntity('The email address entered is a member of a forbidden domain: ' . $email_parts[1]);
        Email::where('email', Input::get('email'))->onlyTrashed()->restore();
        $item = Email::updateOrCreate(['email' => Input::get('email')], Input::all());
        // If the item is not verified then generate a new verification token
        $item->verification_token = ($item->verified) ? null : Helper::generateVerificationToken();
        $item->save();

        if (isset($item->verification_token)) {
            return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated, $item->verification_token);
        } else {
            return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
        }
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
        Email::findOrFail($id)->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function destroyByAddress(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'email' => 'email|required|exists:emails,email,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        Email::where('email', $request->input('email'))->firstOrFail()->delete();
        return $this->respondDestroySuccess();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userEmails($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->emails()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userVerifiedEmails($id, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::findOrFail($id)->emails()->where('verified', true)->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return mixed
     */
    public function userEmailsByIdentifier($identifier, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('identifier', $identifier)->firstOrFail()->emails()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }

    /**
     * @param $identifier
     * @param Request $request
     * @return mixed
     */
    public function userVerifiedEmailsByIdentifier($identifier, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('identifier', $identifier)->firstOrFail()->emails()->where('verified', true)->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userEmailsByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->emails()->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }

    /**
     * @param $username
     * @param Request $request
     * @return mixed
     */
    public function userVerifiedEmailsByUsername($username, Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = User::where('username', $username)->firstOrFail()->emails()->where('verified', true)->paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->emailTransformer->transformCollection($result->all()));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeUserEmailByIdentifier(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'identifier' => 'string|required|exists:users,identifier,deleted_at,NULL',
            'email' => 'email|required|unique:emails,deleted_at,NULL',
            'verified' => 'boolean',
            //'verification_token' => 'string|max:6|min:3|unique:emails,deleted_at,NULL|unique:phones,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        // Get an array of excluded email domains
        $excluded_domains = explode(',', env('EMAIL_MODEL_EXCLUDE_DOMAINS', ''));
        $email_parts = explode('@', Input::get('email'));
        if (in_array($email_parts[1], $excluded_domains)) return $this->respondUnprocessableEntity('The email address entered is a member of a forbidden domain: ' . $email_parts[1]);
        $user = User::where('identifier', $request->input('identifier'))->firstOrFail();
        Email::where('email', Input::get('email'))->onlyTrashed()->restore();
        $item = Email::updateOrCreate(['email' => Input::get('email')], ['user_id' => $user->id, 'email' => Input::get('email')]);
        // If the item is not verified then generate a new verification token
        $item->verification_token = ($item->verified) ? null : Helper::generateVerificationToken();
        $item->save();

        if (isset($item->verification_token)) {
            return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated, $item->verification_token);
        } else {
            return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function storeUserEmailByUsername(Request $request)
    {
        if (!$this->isAuthorized($request, $this->type)) return $this->respondNotAuthorized();
        $validator = Validator::make($request->all(), [
            'username' => 'string|required|exists:users,username,deleted_at,NULL',
            'email' => 'email|required|unique:emails,deleted_at,NULL',
            'verified' => 'boolean',
            //'verification_token' => 'string|max:6|min:3|unique:emails,deleted_at,NULL|unique:phones,deleted_at,NULL'
        ]);
        if ($validator->fails()) return $this->respondUnprocessableEntity($validator->errors()->all());
        // Get an array of excluded email domains
        $excluded_domains = explode(',', env('EMAIL_MODEL_EXCLUDE_DOMAINS', ''));
        $email_parts = explode('@', Input::get('email'));
        if (in_array($email_parts[1], $excluded_domains)) return $this->respondUnprocessableEntity('The email address entered is a member of a forbidden domain: ' . $email_parts[1]);
        $user = User::where('username', $request->input('username'))->firstOrFail();
        Email::where('email', Input::get('email'))->onlyTrashed()->restore();
        $item = Email::updateOrCreate(['email' => Input::get('email')], ['user_id' => $user->id, 'email' => Input::get('email')]);
        // If the item is not verified then generate a new verification token
        $item->verification_token = ($item->verified) ? null : Helper::generateVerificationToken();
        $item->save();

        if (isset($item->verification_token)) {
            return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated, $item->verification_token);
        } else {
            return $this->respondCreateUpdateSuccess($id = $item->id, $item->wasRecentlyCreated);
        }
    }

}
