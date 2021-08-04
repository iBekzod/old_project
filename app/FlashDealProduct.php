<?php

namespace App;

use App\Http\Resources\FlashDealCollection;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class FlashDealProduct extends Model
{
    protected $appends = [
        'flash_deal'
    ];
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getFlashDealAttribute()
    {
        return new FlashDealCollection(FlashDeal::where('id', $this->flash_deal_id)->get());
    }
}
