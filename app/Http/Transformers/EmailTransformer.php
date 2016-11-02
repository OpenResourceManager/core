<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 10/26/16
 * Time: 2:42 PM
 */

namespace App\Http\Transformers;

use League\Fractal\TransformerAbstract;
use App\Http\Models\API\Email;

class EmailTransformer extends TransformerAbstract
{
    /**
     * @param Email $email
     * @return array
     */
    public function transform(Email $email)
    {
        return [
            'id' => $email->id,
            'account_id' => $email->account_id,
            'address' => $email->address,
            'created' => date('Y-m-d - H:i:s', strtotime($email->created_at)),
            'updated' => date('Y-m-d - H:i:s', strtotime($email->updated_at)),
        ];
    }

}