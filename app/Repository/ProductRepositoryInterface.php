<?php

namespace App\Repository;


use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{

    /**
     *  store a product to db
     * @param array $attributes
     * @return Product
     */
    public function create(array $attributes): Product;

    /**
     * get list of nearest store with some products
     * @param array $all
     * @return LengthAwarePaginator
     */
    public function all(array $all): LengthAwarePaginator;
}
