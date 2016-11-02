<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/26/16
 * Time: 2:42 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Duty;

class DutyTransformer extends TransformerAbstract
{
    /**
     * @param Duty $duty
     * @return array
     */
    public function transform(Duty $duty)
    {
        return [
            'id' => $duty->id,
            'code' => $duty->code,
            'label' => $duty->label,
            'created' => date('Y-m-d - H:i:s', strtotime($duty->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($duty->updated_at)),
        ];
    }

}