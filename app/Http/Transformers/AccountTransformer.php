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
            'name_phonetic' => $item->name_phonetic,
        ];




        $user = auth()->user();


        if ($user->hasPermission(Permission::where('name', 'read-duty')->firstOrFail())) {
            $dutyTrans = new DutyTransformer();
            $transformed['primary_duty'] = $dutyTrans->transform($item->primaryDuty);
            $transformed['duties'] = array();
            foreach ($item->duties as $duty) {
                $transformed['duties'][] = $dutyTrans->transform($duty);
            }
        }


        $readClassified = Permission::where('name', 'read-classified')->firstOrFail();
        $writeClassified = Permission::where('name', 'write-classified')->firstOrFail();

        if ($user->hasPermissions([$readClassified, $writeClassified])) {
            $transformed['ssn'] = (!empty($item->ssn)) ? strval(decrypt($item->ssn)) : null;
            $transformed['password'] = (!empty($item->password)) ? decrypt($item->password) : null;
            $transformed['birth_date'] = (!empty($item->birth_date)) ? decrypt($item->birth_date) : null;
        }


        if ($user->hasPermission(Permission::where('name', 'read-email')->firstOrFail())) {
            $transformed['emails'] = array();
            $emailTrans = new EmailTransformer();
            foreach ($item->emails as $email) {
                $transformed['emails'][] = $emailTrans->transform($email);
            }
        }

        if ($user->hasPermission(Permission::where('name', 'read-course')->firstOrFail())) {
            $transformed['courses'] = array();
            $courseTrans = new CourseTransformer();
            foreach ($item->courses as $course) {
                $transformed['courses'][] = $courseTrans->transform($course);
            }
        }

        if ($user->hasPermission(Permission::where('name', 'read-email')->firstOrFail())) {
            $transformed['emails'] = array();
            $emailTrans = new EmailTransformer();
            foreach ($item->emails as $email) {
                $transformed['emails'][] = $emailTrans->transform($email);
            }
        }

        if ($user->hasPermission(Permission::where('name', 'read-mobile-phone')->firstOrFail())) {
            $transformed['mobile_phones'] = array();
            $phoneTrans = new MobilePhoneTransformer();
            foreach ($item->mobilePhones as $mobilePhone) {
                $transformed['mobile_phones'][] = $phoneTrans->transform($mobilePhone);
            }
        }

        if ($user->hasPermission(Permission::where('name', 'read-address')->firstOrFail())) {
            $transformed['addresses'] = array();
            $addressTrans = new AddressTransformer();
            foreach ($item->addresses as $address) {
                $transformed['addresses'][] = $addressTrans->transform($address);
            }
        }

        $transformed['created'] = date('Y-m-d - H:i:s', strtotime($item->created_at));
        $transformed['updated'] = date('Y-m-d - H:i:s', strtotime($item->updated_at));
        return $transformed;
    }

}