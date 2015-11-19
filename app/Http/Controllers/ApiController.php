<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;

class ApiController extends ApiGuardController
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
     * @var int
     */
    protected $limit = 25;


    /**
     * @var int
     */
    protected
        $max_limit = 100;


    /**
     * @param $amount
     * @return $this
     */
    public function limit($amount)
    {
        $this->limit = is_null($amount) ? $this->limit : $amount;
        $this->limit = $this->limit > $this->max_limit ? $this->max_limit : $this->limit;
        return $this;
    }

    /**
     * @param $amount
     * @return $this
     */
    public function max_limit($amount)
    {
        $this->max_limit = $amount;
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

    public function index(Request $request)
    {
        $this->limit(Input::get('limit'));
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
    public
    function respondUnprocessableEntity($message = 'Unprocessable Entity')
    {
        return $this->setStatusCode(422)->respondWithError($message);
    }

    /**
     * @param string $message
     * @param int $id
     * @return mixed
     */
    public function respondCreateSuccess($message = 'Created', $id = 0)
    {
        return $this->setStatusCode(201)->respondWithSuccess(['message' => $message, 'id' => $id]);
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
     * @param string $message
     * @return mixed
     */
    public function respondDestroySuccess($message = 'Object Destroyed')
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
     * @param Request $request
     * @param $limit
     * @param $result
     * @param $data
     * @return mixed
     */
    public function respondSuccessWithPagination(Request $request, LengthAwarePaginator $result, $data)
    {
        $next = $request->path();
        $next = $next . '?limit=' . $result->perPage() . '&page=' . strval(((int)$result->currentPage() + 1));
        $next = ((int)$result->currentPage() + 1) >= (int)$result->lastPage() ? null : $next;

        $previous = $request->path();
        $previous = $previous . '?limit=' . $result->perPage() . '&page=' . strval(((int)$result->currentPage() - 1));
        $previous = ((int)$result->currentPage() - 1) > 0 ? $previous : null;

        $paginator = [
            'total_count' => $result->lastPage(),
            'total_pages' => ceil($result->lastPage() / $result->perPage()),
            'current_page' => $result->currentPage(),
            'limit' => (int)$result->perPage(),
            'next_page' => $next,
            'previous_page' => $previous
        ];

        return $this->respondWithSuccess($data, $paginator);
    }

    /**
     * @param $data
     * @param array $paginator
     * @return mixed
     */
    public function respondWithSuccess($data, $paginator = [])
    {
        return $this->respond([
            'success' => $this->getSuccessStatus(),
            'status_code' => $this->getStatusCode(),
            'pagination' => $paginator,
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
