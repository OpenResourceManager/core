<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Email;
use Illuminate\Http\Request;

class EmailController extends ApiController
{

    /**
     * Show all Email resources
     *
     * Get a paginated array of Emails.
     *
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $duties = Email::paginate($this->resultLimit);
        return $this->response->paginator($duties, new DutyTransformer);
    }

}
