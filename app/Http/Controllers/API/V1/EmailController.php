<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Email;
use App\Http\Transformers\EmailTransformer;
use Illuminate\Http\Request;

class EmailController extends ApiController
{
    /**
     * Show all Emails
     *
     * Get a paginated array of Emails.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $accounts = Email::paginate($this->resultLimit);
        return $this->response->paginator($accounts, new EmailTransformer);
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
