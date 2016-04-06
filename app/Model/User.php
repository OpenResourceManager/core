<?php namespace App\Model;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 6/23/15
 * Time: 3:57 PM
 */

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends BaseModel
{
    use SoftDeletes;

    /**
     * @var string
     */
    public $full_name;

    protected $table = 'users';
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
        'primary_role'
    ];

    public function password()
    {
        return $this->belongsTo('App\Model\Password');
    }

    public function social_security_number()
    {
        return $this->belongsTo('App\Model\SocialSecurityNumber');
    }

    public function birth_date()
    {
        return $this->belongsTo('App\Model\BirthDate');
    }

    public function emails()
    {
        return $this->hasMany('App\Model\Email');
    }

    public function phones()
    {
        return $this->hasMany('App\Model\Phone');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\Model\Room', 'room_user')->withTimestamps();
    }

    public function buildings()
    {
        return $this->hasManyThrough('App\Model\Building', 'App\Model\Room');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Model\Role')->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany('App\Model\Course')->withTimestamps();
    }

    public function departments()
    {
        return $this->belongsToMany('App\Model\Department')->withTimestamps();
    }

    public function addresses()
    {
        return $this->hasMany('App\Model\Address');
    }

    public function states()
    {
        return $this->hasManyThrough('App\Model\State', 'App\Model\Address');
    }

    public function countries()
    {
        return $this->hasManyThrough('App\Model\Country', 'App\Model\Address');
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
}
