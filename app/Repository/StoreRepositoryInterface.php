<?php

namespace App\Repository;


use App\Models\Store;

interface StoreRepositoryInterface
{

    /**
     *  store a store to db
     * @param array $attributes
     * @return Store
     */
    public function create(array $attributes): Store;
}
