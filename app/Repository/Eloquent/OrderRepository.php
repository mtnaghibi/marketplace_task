<?php

namespace App\Repository\Eloquent;

use App\Models\Order;
use App\Repository\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    protected $order;

    /**
     * OrderRepository constructor.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Order
    {
        return $this->order->create($attributes);
    }
}
