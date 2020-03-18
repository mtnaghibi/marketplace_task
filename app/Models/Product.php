<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'store_id','stock_count'
    ];
    /**
     * Get the store record associated with the product.
     */
    public function store()
    {
        return $this->hasOne(Store::class);
    }
}
