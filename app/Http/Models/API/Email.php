<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends BaseApiModel
{
    use SoftDeletes;

    protected $table = 'emails';
    protected $dates = ['deleted_at'];
    protected $fillable = ['account_id', 'email', 'verified'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Account::class);
    }
}
