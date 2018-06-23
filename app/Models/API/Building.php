<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Building extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'buildings';
    protected $dates = ['deleted_at'];
    protected $fillable = ['campus_id', 'code', 'label', 'latitude', 'longitude'];
    protected $touches = ['campus'];

    /**
     * @return HasMany
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * @return BelongsTo
     */
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    /**
     * @return BelongsToMany
     */
    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'rooms', 'building_id', 'account_id');
    }

    /**
     * @return BelongsToMany
     */
    public function inhabitants()
    {
        return $this->accounts();
    }
}
