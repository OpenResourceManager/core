<?php

namespace App\Http\Models\API;

use Illuminate\Database\Eloquent\SoftDeletes;
use League\Flysystem\Exception;

class Account extends BaseApiModel
{
    use SoftDeletes;

    public $full_name;
    protected $table = 'accounts';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'identifier',
        'name_prefix',
        'name_first',
        'name_middle',
        'name_last',
        'name_postfix',
        'name_phonetic',
        'username',
        'primary_duty'
    ];

    protected $classified = ['password', 'ssn', 'birth_date'];

    /**
     * If the current user cannot read or write classified attributes then hide them
     */
    public function setClassifiedVisibility($permitted = false)
    {
        if ($user = auth()->user()) {
            try {
                $permitted = $user->can(['read-classified', 'write-classified']);
            } catch (Exception $e) {
                $permitted = false;
            }
        }

        if (!$permitted) $this->setHidden($this->classified);
    }

    /**
     * Account constructor.
     */
    public function __construct($attributes = array(), $permitted = false)
    {
        parent::__construct($attributes);
        $this->setClassifiedVisibility($permitted);
    }

    /**
     * @return string
     */
    public function format_first_name()
    {
        $this->name_first = ucwords(strtolower($this->name_first), ' ');
        return $this->name_first;
    }

    /**
     * @return string
     */
    public function format_middle_name()
    {
        if (!empty($this->name_middle)) {
            // If the middle name is only letter follow it up with a period.
            if (strlen($this->name_middle) === 1) {
                $this->name_middle = $this->name_middle . '.';
            }
            $this->name_middle = ucwords(strtolower($this->name_middle), ' ');
            return $this->name_middle;
        }
        return null;
    }

    /**
     * @return string
     */
    public function format_last_name()
    {
        $this->name_last = ucwords(strtolower($this->name_last), ' ');
        return $this->name_last;
    }

    /**
     * @return string
     */
    public function format_full_name()
    {
        if (empty($this->name_middle)) {
            // Form CN from first and last name since middle name is empty.
            $full_name = $this->format_first_name() . ' ' . $this->format_last_name();
        } else {
            // Middle name exists
            $full_name = $this->format_first_name() . ' ' . $this->format_middle_name() . ' ' . $this->format_last_name();
        }
        // Return the name
        // Make sure that the first letter of the first and last name are capital
        $this->full_name = ucwords(strtolower($full_name), ' ');
        return $this->full_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function duties()
    {
        return $this->belongsToMany(Duty::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }
}