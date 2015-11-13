<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/13/15
 * Time: 2:02 PM
 */
namespace App\UUD\Transformers;

class CourseTransformer extends Transformer
{
    
    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'department_id' => (int)$item['department_id'],
            'code' => $item['code'],
            'name' => $item['name']
        ];
    }
}
