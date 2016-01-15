<?php

namespace App\Http\Controllers;

use App\Model\Password;
use App\UUD\Transformers\PasswordTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PasswordController extends ApiController
{

    /**
     * @var PasswordTransformer
     */
    protected $passwordTransformer;

    /**
     * PasswordController constructor.
     * @param PasswordTransformer $passwordTransformer
     */
    function __construct(PasswordTransformer $passwordTransformer)
    {
        $this->passwordTransformer = $passwordTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        if (!$this->canManagePassword($request)) return $this->respondNotAuthorized();
        parent::index($request);
        $result = Password::paginate($this->limit);
        return $this->respondSuccessWithPagination($request, $result, $this->passwordTransformer->transformCollection($result->all()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$this->isAuthorized($request)) return $this->respondNotAuthorized();
        if (!$this->canManagePassword($request)) return $this->respondNotAuthorized();
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
        if (!$this->canManagePassword($request)) return $this->respondNotAuthorized();
        //
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
        if (!$this->canManagePassword($request)) return $this->respondNotAuthorized();
        //
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
        if (!$this->canManagePassword($request)) return $this->respondNotAuthorized();
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
        if (!$this->canManagePassword($request)) return $this->respondNotAuthorized();
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
        if (!$this->canManagePassword($request)) return $this->respondNotAuthorized();
        //
    }
}
