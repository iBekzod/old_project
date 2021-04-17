<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class FlashDealProduct extends Model
{
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
