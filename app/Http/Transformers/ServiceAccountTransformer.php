<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 3/24/17
 * Time: 2:42 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\ServiceAccount;

class ServiceAccountTransformer extends TransformerAbstract
{
    /**
     * @param ServiceAccount $item
     * @return array
     */
    public function transform(ServiceAccount $item)
    {
        $user = auth()->user();

        $transformed = [
            'id' => $item->id,
            'account_id' => $item->account_id,
            'identifier' => $item->identifier,
            'username' => $item->username,
            'name_first' => $item->name_first,
            'name_last' => $item->name_last
        ];

        $permissions = [];
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $name = $permission->name;
                if (!in_array($name, $permissions)) {
                    $permissions[] = $name;
                }
            }
        }

        if (in_array('read-service-classified', $permissions)) {
            $transformed['password'] = (!empty($item->password)) ? decrypt($item->password) : null;
        }

        $transformed['disabled'] = $item->disabled;
        $transformed['expired'] = $item->expired();
        if (!is_null($item->expires_at) && !empty($item->expires_at)) {
            $transformed['expires'] = date('Y-m-d - H:i:s', strtotime($item->expires_at));
        } else {
            $transformed['expires'] = $item->expires_at;
        }
        $transformed['created'] = date('Y-m-d - H:i:s', strtotime($item->created_at));
        $transformed['updated'] = date('Y-m-d - H:i:s', strtotime($item->updated_at));
        return $transformed;
    }

}