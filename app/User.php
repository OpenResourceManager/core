<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @SWG\Definition(required={
 *     "name",
 *     "email",
 *     "username",
 *     "password"
 * }, @SWG\Xml(name="User"))
 */
class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
