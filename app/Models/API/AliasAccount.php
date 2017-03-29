<?php

namespace App\Http\Models\API;

use App\Models\Access\Permission\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AliasAccount extends BaseApiModel
{
    use SoftDeletes;
    protected $table = 'alias_accounts';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'identifier',
        'username',
        'password',
        'should_propagate_password',
        'expires_at',
        'disabled',
        'account_id'
    ];
    protected $classified = ['password'];

    /**
     * If the current user cannot read or write classified attributes then hide them
     */
    public function setClassifiedVisibility($permitted = false)
    {
        if ($user = auth()->user()) {
            try {
                $readClassified = Permission::where('name', 'read-alias-classified')->firstOrFail();
                $writeClassified = Permission::where('name', 'write-alias-classified')->firstOrFail();
                $permitted = $user->hasPermissions([$readClassified, $writeClassified]);
            } catch (Exception $e) {
                $permitted = false;
            }
        }

        if (!$permitted) $this->setHidden($this->classified);
    }

    /**
     * AliasAccount constructor.
     * @param array $attributes
     * @param bool $permitted
     */
    public function __construct($attributes = array(), $permitted = false)
    {
        parent::__construct($attributes);
        $this->setClassifiedVisibility($permitted);
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
     * @return BelongsTo
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
