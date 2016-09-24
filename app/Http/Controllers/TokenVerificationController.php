<?php

namespace App\Http\Controllers;

use App\UUD\Transformers\EmailTransformer;
use App\UUD\Transformers\PhoneTransformer;
use Illuminate\Http\Request;
use App\UUD\Helper;
use ReflectionClass;

class TokenVerificationController extends ApiController
{
    /**
     * @param $token
     * @return mixed
     */
    public function verify($token)
    {
        $verified = Helper::verifyToken($token);
        if ($verified) {

            $reflection = new ReflectionClass(get_class($verified));
            $type = strtolower($reflection->getShortName());

            switch ($type) {
                case 'email':
                    $transformer = new EmailTransformer();
                    $item = $transformer->transform($verified);
                    break;
                case 'phone':
                    $transformer = new PhoneTransformer();
                    $item = $transformer->transform($verified);
                    break;
                default:
                    $item = null;
                    break;
            }

            return $this->respondVerifySuccess('Verified', $verified->id, $type, $item);
        } else {
            return $this->respondNotFound();
        }
    }
}
