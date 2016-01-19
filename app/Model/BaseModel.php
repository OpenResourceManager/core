<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 1/5/16
 * Time: 12:20 PM
 */

/**
 * @TODO Write Mobile Carrier model
 * @TODO Modify phone model to use carrier_id
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination;

class BaseModel extends Model
{

    public function manyThroughMany($related, $through, $firstKey, $secondKey, $pivotKey)
    {
        $model = new $related;
        $table = $model->getTable();
        $throughModel = new $through;
        $pivot = $throughModel->getTable();

        return $model
            ->join($pivot, $pivot . '.' . $pivotKey, '=', $table . '.' . $secondKey)
            ->select($table . '.*')
            ->where($pivot . '.' . $firstKey, '=', $this->id);
    }
}