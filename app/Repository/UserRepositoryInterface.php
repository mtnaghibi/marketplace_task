<?php

namespace App\Repository;


use App\User;

interface UserRepositoryInterface
{

    /**
     *  store a user to db
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes): User;
}
