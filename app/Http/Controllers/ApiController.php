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
     * @param string $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondNotAuthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondUnprocessableEntity($message = 'Unprocessable Entity')
    {
        return $this->setStatusCode(422)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondCreateSuccess($message = 'Created')
    {
        return $this->respondWithSuccess($message);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respondUpdateSuccess($message = 'Updated')
    {
        return $this->respondWithSuccess($message);
    }

    /**
     * @param $message
     * @return mixed
     */
    public function respondWithError($message = 'An Error Has Occurred')
    {
        $this->setSuccessStatus(false);

        return $this->respond([
            'success' => $this->getSuccessStatus(),
            'status_code' => $this->getStatusCode(),
            'error' => $message
        ]);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function respondWithSuccess($data)
    {
        return $this->respond([
            'success' => $this->getSuccessStatus(),
            'status_code' => $this->getStatusCode(),
            'result' => $data
        ]);
    }

    /**
     * @param string $message
     * @return mixed
     */
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }

}
