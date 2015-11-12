<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\Type\Campus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CampusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Campus::all();

        return Response::json([
            'success' => true,
            'result' => $this->transform($result)
        ], 200);
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
            return Response::json([
                'success' => false,
                'error' => 'Not found'
            ], 404);
        }

        return Response::json([
            'success' => true,
            'result' => $result
        ], 200);
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
     * @param $campuses
     * @return array
     */
    private function transform($campuses)
    {
        return array_map(function ($campus) {
            return [
                'code' => $campus['code'],
                'name' => $campus['name']
            ];
        }, $campuses->toArray());
    }
}
