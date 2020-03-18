<?php

namespace App\Repository;


use App\Models\Order;

interface OrderRepositoryInterface
{

    /**
     *  store a order to db
     * @param array $attributes
     * @return Order
     */
    public function create(array $attributes): Order;

}
