<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var bool
     */
    protected $successStatus = true;

    /**
     * @return boolean
     */
    public function getSuccessStatus()
    {
        return $this->successStatus;
    }

    /**
     * @param boolean $successStatus
     */
    public function setSuccessStatus($successStatus)
    {
        $this->successStatus = $successStatus;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return Response::json([
            'success' => $this->getSuccessStatus(),
            'status_code' => $this->getStatusCode(),
            'error' => $message
        ], $this->getStatusCode());
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respond($data)
    {
        return Response::json([
            'success' => $this->getSuccessStatus(),
            'status_code' => $this->getStatusCode(),
            'result' => $data
        ], $this->getStatusCode());
    }

}
