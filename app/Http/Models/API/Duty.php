<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;

class Duty extends BaseApiModel
{
    use SoftDeletes;

    protected $table = 'duties';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code', 'label'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

}
