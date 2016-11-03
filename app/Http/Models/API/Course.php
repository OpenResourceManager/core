<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Course extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'courses';
    protected $dates = ['deleted_at'];
    protected $fillable = ['department_id', 'code', 'course_level', 'label'];

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
    public function participants()
    {
        return $this->accounts();
    }

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

}
