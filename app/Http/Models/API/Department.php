<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'departments';
    protected $dates = ['deleted_at'];
    protected $fillable = ['academic', 'code', 'name'];

    /**
     * @return HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

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
