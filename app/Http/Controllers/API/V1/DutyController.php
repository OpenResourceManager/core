<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Duty;
use App\Http\Transformers\DutyTransformer;

class DutyController extends ApiController
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $duties = Duty::paginate($this->resultLimit);

        return $this->response->paginator($duties, new DutyTransformer);
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $duty = Duty::findOrFail($id);

        return $this->response->item($duty, new DutyTransformer);
    }
}
