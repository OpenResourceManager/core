<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Campus extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'campuses';
    protected $dates = ['deleted_at'];
    protected $fillable = ['code', 'label'];

    /**
     * @return HasMany
     */
    public function buildings()
    {
        #return $this->hasMany(Building::class)->with(Room::class)->with(Account::class);
        return $this->hasMany(Building::class);
    }

    /**
     * @return HasManyThrough
     */
    public function rooms()
    {
        return $this->hasManyThrough(Room::class, Building::class);
    }
}
