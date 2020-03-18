<?php

namespace App;

use App\CustomCasts\RoleCast;
use App\Models\Store;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public const ROLE_ADMIN='admin';
    public const ROLE_SELLER='seller';
    public const ROLE_CUSTOMER='customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the user's Role.
     *
     * @param $value
     * @return array
     */
    public function getRoleAttribute($value)
    {
        return empty($value) ? [] : explode(',', $value);
    }

    /**
     * Set the user's Role.
     *
     * @param array $value
     * @return void
     */
    public function setRoleAttribute($value)
    {
        $this->attributes['role'] = implode(',', array_unique($value));
    }

    /**
     * @inheritDoc
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritDoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the store record associated with the user.
     */
    public function store()
    {
        return $this->hasOne(Store::class);
    }
}
