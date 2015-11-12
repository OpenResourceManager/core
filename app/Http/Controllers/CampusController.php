<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\Type\Campus;
use App\UUD\Transformers\CampusTransformer;
use Illuminate\Http\Request;

class CampusController extends ApiController
{

    /**
     * @var \App\UUD\Transformers\CampusTransformer
     */
    protected $campusTransformer;

    /**
     * @param CampusTransformer $campusTransformer
     */
    function __construct(CampusTransformer $campusTransformer)
    {
        $this->campusTransformer = $campusTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Campus::all();

        return $this->respond($this->campusTransformer->transform($result));
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
        $result = Campus::find($id);

        if (!$result) {
            return $this->respondNotFound();
        }

        return $this->respond($this->campusTransformer->transform($result));
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
