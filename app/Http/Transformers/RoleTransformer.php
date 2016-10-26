<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/26/16
 * Time: 2:42 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Role;

class RoleTransformer extends TransformerAbstract
{
    /**
     * @param Role $role
     * @return array
     */
    public function transform(Role $role)
    {
        return [
            'id' => $role->id,
            'code' => $role->code,
            'name' => $role->label,
            'created' => date('Y-m-d', strtotime($role->created_at)),
            'updated' => date('Y-m-d', strtotime($role->updated_at)),
        ];
    }

}