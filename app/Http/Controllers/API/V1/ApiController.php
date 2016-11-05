<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;


class ApiController extends Controller
{

    use Helpers;

    /**
     * A name describing the model that this controller relates to.
     * Makes it easier to dynamically provide contextual errors.
     *
     * @var string
     */
    protected $noun = 'resource';

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

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function destroySuccessResponse()
    {
        return $this->response->noContent()->setStatusCode(204);
    }

    /**
     * @param string $resource
     */
    public function destroyFailure($resource = 'resource')
    {
        throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not delete ' . $resource . '.');
    }

    /**
     * @param string $resource1
     * @param string $resource2
     */
    public function detachFailure($resource1 = 'resource', $resource2 = 'resource')
    {
        throw new \Dingo\Api\Exception\DeleteResourceFailedException('Could not detach ' . $resource1 . ' from ' . $resource2 . '.');
    }

    /**
     * @param string $resource1
     * @param string $resource2
     */
    public function assignFailure($resource1 = 'resource', $resource2 = 'resource')
    {
        throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not assign ' . $resource1 . ' to ' . $resource2 . '.');
    }
}
