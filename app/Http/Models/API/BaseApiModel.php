<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\Model;

class BaseApiModel extends Model
{
    /**
     * @param $related
     * @param $through
     * @param $firstKey
     * @param $secondKey
     * @param $pivotKey
     * @return mixed
     */
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
