<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoadStatus extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'load_statuses';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code', 'label'];

    /**
     * @return HasMany
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * @return HasMany
     */
    public function members()
    {
        return $this->accounts();
    }
}
