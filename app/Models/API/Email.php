<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'emails';
    protected $dates = ['deleted_at'];
    protected $fillable = ['account_id', 'address', 'verified'];
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
}
