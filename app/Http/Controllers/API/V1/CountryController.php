<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Country;
use App\Http\Transformers\CountryTransformer;
use Illuminate\Http\Request;

class CountryController extends ApiController
{
    /**
     * Show all Countries
     *
     * Get a paginated array of Countries.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Country::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new CountryTransformer);
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
