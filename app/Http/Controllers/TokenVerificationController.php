<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UUD\Helper;

class TokenVerificationController extends ApiController
{

    public function verify($token)
    {
        $verified = Helper::verifyToken($token);
        if ($verified) {
            return $this->respondVerifySuccess($message = 'Verified', $id = $verified->id);
        } else {
            return $this->respondNotFound();
        }
    }
}
