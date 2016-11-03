<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'addresses';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'account_id',
        'addressee',
        'organization',
        'line_1',
        'line_2',
        'city',
        'state_id',
        'zip',
        'country_id',
        'latitude',
        'longitude'
    ];
    protected $touches = [Account::class];

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->account();
    }
}
