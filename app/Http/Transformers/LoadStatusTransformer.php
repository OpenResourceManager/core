<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/26/16
 * Time: 2:42 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\LoadStatus;

class LoadStatusTransformer extends TransformerAbstract
{
    /**
     * @param LoadStatus $item
     * @return array
     */
    public function transform(LoadStatus $item)
    {
        return [
            'id' => $item->id,
            'code' => $item->code,
            'label' => $item->label,
            'created' => date('Y-m-d - H:i:s', strtotime($item->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($item->updated_at)),
        ];
    }

}