<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'countries';
    protected $dates = ['deleted_at'];
    protected $fillable = ['label', 'code', 'abbreviation'];

    /**
     * @return HasMany
     */
    public function states()
    {
        return $this->hasMany(State::class);
    }

    /**
     * @return HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return HasMany
     */
    public function mobileCarriers()
    {
        return $this->hasMany(MobileCarrier::class);
    }

    /**
     * @return HasManyThrough
     */
    public function accounts()
    {
        return $this->hasManyThrough(Account::class, Address::class);
    }
}
