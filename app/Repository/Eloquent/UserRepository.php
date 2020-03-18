<?php

namespace App\Repository\Eloquent;

use App\Repository\UserRepositoryInterface;
use App\User;

class UserRepository implements UserRepositoryInterface
{
    protected $user;

    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): User
    {
        $user = User::where('email', $attributes['email'])->first();
        if ($user) {
            $user->role = array_merge($user->role, $attributes['role']);
            $user->name = $attributes['name'];
            $user->password = $attributes['password'];
            $user->save();
            return $user;
        } else
            return $this->user->create($attributes);
    }
}
