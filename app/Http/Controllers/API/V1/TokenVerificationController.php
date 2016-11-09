<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Transformers\EmailTransformer;
use App\Http\Transformers\MobilePhoneTransformer;
use ReflectionClass;

class TokenVerificationController extends ApiController
{

    /**
     * TokenVerificationController constructor.
     */
    public function __construct()
    {
        $this->noun = 'token';
    }

    /**
     * @param Request $request
     * @param String $token
     * @return \Dingo\Api\Http\Response|void
     */
    public function verify(Request $request, $token = null)
    {

        if ($request->isMethod('post') && empty($token)) {
            $data = $request->all();
            $token = $data['token'];
        }

        $verified = verifyToken($token);

        if ($verified) {
            $reflection = new ReflectionClass(get_class($verified));
            $type = strtolower($reflection->getShortName());

            switch ($type) {
                case 'email':
                    $trans = new EmailTransformer();
                    $route = route('api.emails.show', ['id' => $verified->id]);
                    break;
                case 'mobilephone':
                    $trans = new MobilePhoneTransformer();
                    $route = route('api.mobile-phones.show', ['id' => $verified->id]);
                    break;
                default:
                    return $this->response->accepted();
                    break;
            }
            $item = $trans->transform($verified);

            return $this->response->accepted($route, ['data' => $item]);
        } else {
            return $this->response->errorNotFound('Token Not Found');
        }
    }

}
