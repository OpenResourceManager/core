<?php

namespace App\Http\Models\API;

use App\Models\Access\Permission\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use League\Flysystem\Exception;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        'primary_duty_id',
        'load_status_id',
        'ssn',
        'password',
        'should_propagate_password',
        'birth_date',
        'expires_at',
        'disabled'
    ];
    protected $classified = ['password', 'ssn', 'birth_date'];

    /**
     * If the current user cannot read or write classified attributes then hide them
     */
    public function setClassifiedVisibility($permitted = false)
    {
        if ($user = auth()->user()) {
            try {
                $readClassified = Permission::where('name', 'read-classified')->firstOrFail();
                $writeClassified = Permission::where('name', 'write-classified')->firstOrFail();
                $permitted = $user->hasPermissions([$readClassified, $writeClassified]);
            } catch (Exception $e) {
                $permitted = false;
            }
        }

        if (!$permitted) $this->setHidden($this->classified);
    }

    /**
     * Account constructor.
     * @param array $attributes
     * @param bool $permitted
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
        $this->name_last = ucwords(strtolower($this->name_last), " \t-");
        return $this->name_last;
    }

    /**
     * @return string
     */
    public function format_full_name($proper = false)
    {
        if (empty($this->name_middle)) {
            // Form CN from first and last name since middle name is empty.
            $full_name = $this->format_first_name() . ' ' . $this->format_last_name();
        } else {
            // Middle name exists
            $full_name = $this->format_first_name() . ' ' . $this->format_middle_name() . ' ' . $this->format_last_name();
        }

        if ($proper) {
            if (!empty($this->name_prefix)) $full_name = $this->name_prefix . ' ' . $full_name;
            if (!empty($this->name_postfix)) $full_name = $full_name . ' ' . $this->name_postfix;
        }

        // Return the name
        // Make sure that the first letter of the first and last name are capital
        $this->full_name = ucwords(strtolower($full_name), ' ');
        return $this->full_name;
    }

    /**
     * @return bool
     */
    public function expired()
    {
        // If the expires_at value does not exists, the account never expires
        if ($this->expires_at == false || is_null($this->expires_at)) {
            // Account is NOT expired
            return false;
        } else {
            // Check to see if the date is in the future
            $e = new Carbon($this->expires_at);
            if ($e >= Carbon::now()) {
                // Account is NOT expired
                return false;
            } else {
                // Account IS expired
                return true;
            }
        }
    }

    /**
     * @param bool $value
     * @return mixed
     */
    public function set_propagate_password(bool $value = false)
    {
        return DB::update('update accounts set should_propagate_password = ? where id = ?', [intval($value), $this->id]);
    }

    /**
     *
     *
     * Relationships
     *
     */

    /**
     * @return BelongsToMany
     */
    public function duties()
    {
        return $this->belongsToMany(Duty::class);
    }

    /**
     * @return BelongsTo
     */
    public function primaryDuty()
    {
        return $this->belongsTo(Duty::class, 'primary_duty_id');
    }

    /**
     * @return BelongsTo
     */
    public function loadStatus()
    {
        return $this->belongsTo(LoadStatus::class, 'load_status_id');
    }

    /**
     * @return HasMany
     */
    public function emails()
    {
        return $this->hasMany(Email::class);
    }

    /**
     * @return HasMany
     */
    public function mobilePhones()
    {
        return $this->hasMany(MobilePhone::class);
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
    public function aliasAccounts()
    {
        return $this->hasMany(AliasAccount::class);
    }

    /**
     * @return HasMany
     */
    public function serviceAccounts()
    {
        return $this->hasMany(AliasAccount::class);
    }

    /**
     * @return BelongsToMany
     */
    public function rooms()
    {
        return $this->belongsToMany(Room::class);
    }

    /**
     * @return BelongsToMany
     */
    public function schools()
    {
        return $this->belongsToMany(School::class);
    }

    /**
     * @return BelongsToMany
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    /**
     * @return BelongsToMany
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}