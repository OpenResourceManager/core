<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class State extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'states';
    protected $dates = ['deleted_at'];
    protected $fillable = ['country_id', 'label', 'code'];
    protected $touches = ['country'];

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * @return HasManyThrough
     */
    public function accounts()
    {
        return $this->hasManyThrough(Account::class, Address::class);
    }

    /**
     * @return HasManyThrough
     */
    public function inhabitants()
    {
        return $this->accounts();
    }
}
