<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'rooms';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'code',
        'building_id',
        'floor_number',
        'floor_label',
        'room_number',
        'room_label'
    ];
    protected $touches = [Building::class];

    /**
     * @return BelongsTo
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * @return BelongsTo
     */
    public function accounts()
    {
        return $this->belongsTo(Account::class)->withTimestamps();
    }

    /**
     * @return BelongsTo
     */
    public function inhabitants()
    {
        return $this->accounts();
    }

}
