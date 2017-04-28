<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Course;
use App\Models\Access\Permission\Permission;

class CourseTransformer extends TransformerAbstract
{

    /**
     * @param Course $item
     * @return array
     */
    public function transform(Course $item)
    {
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

        $readDepartment = Permission::where('name', 'read-department')->first();

        if (in_array('read-department', $permissions) || $user->hasPermission($readDepartment)) {

            $deptTrans = new DepartmentTransformer();

            return [
                'id' => (int)$item->id,
                'code' => $item->code,
                'course_level' => $item->course_level,
                'label' => $item->label,
                'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
                'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
                'department' => $deptTrans->transform($item->department),
            ];
        } else {

            return [
                'id' => (int)$item->id,
                'code' => $item->code,
                'course_level' => $item->course_level,
                'label' => $item->label,
                'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
                'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
            ];
        }

    }

}