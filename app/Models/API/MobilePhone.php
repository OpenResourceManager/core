<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MobilePhone extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'mobile_phones';
    protected $dates = ['deleted_at'];
    protected $fillable = ['account_id', 'number', 'country_code', 'mobile_carrier_id', 'verified', 'verification_callback'];
    protected $touches = ['account'];


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

    /**
     * @return BelongsTo
     */
    public function mobileCarrier()
    {
        return $this->belongsTo(MobileCarrier::class);
    }

    /**
     * @return BelongsTo
     */
    public function carrier()
    {
        return $this->mobileCarrier();
    }
}
