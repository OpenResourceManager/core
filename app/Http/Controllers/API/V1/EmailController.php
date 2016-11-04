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
     * Show a Email
     *
     * Display an Email by providing it's ID attribute.
     *
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $item = Email::findOrFail($id);
        return $this->response->item($item, new EmailTransformer);
    }

    /**
     * Show Duty by Address
     *
     * Display an Email by providing it's Address attribute.
     *
     * @param $code
     * @return \Dingo\Api\Http\Response
     */
    public function showFromAddress($address)
    {
        $item = Email::where('address', $address)->firstOrFail();
        return $this->response->item($item, new EmailTransformer);
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
