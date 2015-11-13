<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 11/13/15
 * Time: 2:02 PM
 */
namespace App\UUD\Transformers;

class DepartmentTransformer extends Transformer
{

    /**
     * @param $item
     * @return array
     */
    public function transform($item)
    {
        return [
            'id' => (int)$item['id'],
            'academic' => (bool)$item['academic'],
            'code' => $item['code'],
            'name' => $item['name']
        ];
    }
}
