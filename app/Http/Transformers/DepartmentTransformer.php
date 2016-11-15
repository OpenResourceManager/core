<?php

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Department;

class DepartmentTransformer extends TransformerAbstract
{

    /**
     * @param Department $item
     * @return array
     */
    public function transform(Department $item)
    {
        return [
            'id' => (int)$item->id,
            'academic' => (bool)$item->academic,
            'code' => $item->code,
            'label' => $item->label,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
        ];
    }

}