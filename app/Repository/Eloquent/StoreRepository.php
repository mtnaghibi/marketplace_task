<?php

namespace App\Repository\Eloquent;

use App\Models\Store;
use App\Repository\StoreRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\Auth;

class StoreRepository implements StoreRepositoryInterface
{
    protected $store;

    /**
     * UserRepository constructor.
     *
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Store
    {
        $store = Store::where('user_id', $attributes['user_id'])->first();
        if ($store) {
            $store->name = $attributes['name'];
            $store->phone = $attributes['phone'];
            $store->save();
            return $store;
        } else
            return $this->store->create($attributes);
    }
}
