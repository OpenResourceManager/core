<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/26/16
 * Time: 2:42 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\AliasAccount;
use App\Models\Access\Permission\Permission;

class AliasAccountTransformer extends TransformerAbstract
{
    /**
     * @param AliasAccount $item
     * @return array
     */
    public function transform(AliasAccount $item)
    {
        $user = auth()->user();

        $transformed = [
            'id' => $item->id,
            'account_id' => $item->account_id,
            'username' => $item->username
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

        $readClassified = Permission::where('name', 'read-alias-classified')->first();
        if (in_array('read-alias-classified', $permissions) || $user->hasPermission($readClassified)) {
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