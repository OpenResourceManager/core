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
        return [
            'id' => (int)$item->id,
            'department_id' => (int)$item->department_id,
            'code' => $item->code,
            'course_level' => $item->course_level,
            'label' => $item->label
        ];
    }

}