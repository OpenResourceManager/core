<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Models\API\Role;
use App\Http\Transformers\RoleTransformer;

class RoleController extends ApiController
{
    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate($this->resultLimit);

        return $this->response->paginator($roles, new RoleTransformer);
    }

    /**
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return $this->response->item($role, new RoleTransformer);
    }
}
