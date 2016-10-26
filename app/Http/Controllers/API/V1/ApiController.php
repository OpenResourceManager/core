<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class ApiController extends Controller
{

    use Helpers;

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var bool
     */
    protected $successStatus = true;

    /**
     * @var int
     */
    protected $resultLimit = 50;


    /**
     * @var int
     */
    protected $maxResultLimit = 1500;


    /**
     * @param $amount
     * @return $this
     */
    public function resultLimit($amount)
    {
        $this->resultLimit = is_null($amount) ? $this->resultLimit : $amount;
        $this->resultLimit = $this->resultLimit > $this->maxResultLimit ? $this->maxResultLimit : $this->resultLimit;
        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function maxResultLimit($amount)
    {
        $this->maxResultLimit = $amount;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getSuccessStatus()
    {
        return $this->successStatus;
    }

    /**
     * @param $successStatus
     * @return $this
     */
    public function setSuccessStatus($successStatus)
    {
        $this->successStatus = $successStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return json_encode([
            'message' => 'ok',
            'status_code' => $this->getStatusCode()
        ]);
    }

}
