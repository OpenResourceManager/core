<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Course;

class CourseTransformer extends TransformerAbstract
{
    
    /**
     * @param Course $item
     * @return array
     */
    public function transform(Course $item)
    {
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
    }

}