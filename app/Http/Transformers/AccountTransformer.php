<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/26/16
 * Time: 2:39 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Account;
use App\Models\Access\Permission\Permission;

class AccountTransformer extends TransformerAbstract
{
    /**
     * @param Account $item
     * @return array
     */
    public function transform(Account $item)
    {
        $transformed = [
            'id' => $item->id,
            'identifier' => $item->identifier,
            'username' => $item->username,
            'name_prefix' => $item->name_prefix,
            'name_first' => $item->name_first,
            'name_middle' => $item->name_middle,
            'name_last' => $item->name_last,
            'name_postfix' => $item->name_postfix,
            'name_phonetic' => $item->name_phonetic
        ];

        $user = auth()->user();
        $permissions = [];
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $name = $permission->name;
                if (!in_array($name, $permissions)) {
                    $permissions[] = $name;
                }
            }
        }

        $readLoadStatus = Permission::where('name', 'read-load-status')->first();
        if (in_array('read-load-status', $permissions) || $user->hasPermission($readLoadStatus)) {
            $transformed['load_status'] = null;
            $loadStatusTransformer = new LoadStatusTransformer();
            if (!empty($item->loadStatus)) {
                $transformed['load_status'] = $loadStatusTransformer->transform($item->loadStatus);
            }
        }

        $readDuty = Permission::where('name', 'read-duty')->first();
        if (in_array('read-duty', $permissions) || $user->hasPermission($readDuty)) {
            $dutyTrans = new DutyTransformer();
            $transformed['primary_duty'] = $dutyTrans->transform($item->primaryDuty);
            $transformed['duties'] = [];
            $duties = [];
            $primary_in_duties = false;
            foreach ($item->duties as $duty) {
                if ($duty->id == $item->primaryDuty->id) $primary_in_duties = true;
                $duties[] = $dutyTrans->transform($duty);
            }
            if (!$primary_in_duties) {
                $transformed['duties'][] = $dutyTrans->transform($item->primaryDuty);
            }
            $transformed['duties'] = array_merge($transformed['duties'], $duties);
        }

        $readClassified = Permission::where('name', 'read-classified')->first();
        if (in_array('read-classified', $permissions) || $user->hasPermission($readClassified)) {
            $transformed['ssn'] = (!empty($item->ssn)) ? strval(decrypt($item->ssn)) : null;
            $transformed['password'] = (!empty($item->password)) ? decrypt($item->password) : null;
            $transformed['birth_date'] = (!empty($item->birth_date)) ? decrypt($item->birth_date) : null;
        }

        $readDepartment = Permission::where('name', 'read-department')->first();
        if (in_array('read-department', $permissions) || $user->hasPermission($readDepartment)) {
            $transformed['departments'] = array();
            $departmentTrans = new DepartmentTransformer();
            foreach ($item->departments as $department) {
                $transformed['departments'][] = $departmentTrans->transform($department);
            }
        }

        $readCourse = Permission::where('name', 'read-course')->first();
        if (in_array('read-course', $permissions) || $user->hasPermission($readCourse)) {
            $transformed['courses'] = array();
            $courseTrans = new CourseTransformer();
            foreach ($item->courses as $course) {
                $transformed['courses'][] = $courseTrans->transform($course);
            }
        }

        $readEmail = Permission::where('name', 'read-email')->first();
        if (in_array('read-email', $permissions) || $user->hasPermission($readEmail)) {
            $transformed['emails'] = array();
            $emailTrans = new EmailTransformer();
            foreach ($item->emails as $email) {
                $transformed['emails'][] = $emailTrans->transform($email);
            }
        }

        $readMobilePhone = Permission::where('name', 'read-mobile-phone')->first();
        if (in_array('read-mobile-phone', $permissions) || $user->hasPermission($readMobilePhone)) {
            $transformed['mobile_phones'] = array();
            $phoneTrans = new MobilePhoneTransformer();
            foreach ($item->mobilePhones as $mobilePhone) {
                $transformed['mobile_phones'][] = $phoneTrans->transform($mobilePhone);
            }
        }

        $readAddress = Permission::where('name', 'read-address')->first();
        if (in_array('read-address', $permissions) || $user->hasPermission($readAddress)) {
            $transformed['addresses'] = array();
            $addressTrans = new AddressTransformer();
            foreach ($item->addresses as $address) {
                $transformed['addresses'][] = $addressTrans->transform($address);
            }
        }

        $readAliasAccount = Permission::where('name', 'read-alias-account')->first();
        if (in_array('read-alias-account', $permissions) || $user->hasPermission($readAliasAccount)) {
            $transformed['alias_accounts'] = array();
            $aliasTrasnsformer = new AliasAccountTransformer();
            foreach ($item->aliasAccounts as $alias) {
                $transformed['alias_accounts'][] = $aliasTrasnsformer->transform($alias);
            }
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