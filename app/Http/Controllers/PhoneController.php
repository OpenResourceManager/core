<?php

namespace App\Http\Controllers;

use App\Model\Record\User;
use App\Model\Record\Phone;
use App\UUD\Transformers\PhoneTransformer;
use Illuminate\Http\Request;
use App\Http\Requests;

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
    public function index()
    {
        $result = Phone::all();
        return $this->respondWithSuccess($this->phoneTransformer->transformCollection($result->all()));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = Phone::find($id);
        if (!$result) return $this->respondNotFound();
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
        //
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userPhones($id)
    {
        $result = User::find($id)->phones;

        return $this->respondWithSuccess($this->phoneTransformer->transformCollection($result->all()));
    }
}
