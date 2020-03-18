<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Models\Store;
use App\Repository\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    protected $product;

    /**
     * ProductRepository constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Product
    {
        return $this->product->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes): LengthAwarePaginator
    {
        return Store::distance($attributes['distance'], $attributes['latitude'] . ',' . $attributes['longitude'])
            ->with(['products' => function ($query) {
                $query->take(10);
            }])
            ->paginate(20);
    }
}
