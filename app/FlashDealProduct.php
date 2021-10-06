<?php

namespace App;

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
        if($flash_deal=FlashDeal::where('id', $this->flash_deal_id)->first()){
            return [
                'title' => $flash_deal->title,
                'slug'=>$flash_deal->slug,
                'start_date' => date('d-m-Y',$flash_deal->start_date),
                'end_date' => date('d-m-Y',$flash_deal->end_date),
            ];
        }
        return [];

        // new FlashDealCollection(FlashDeal::where('id', $this->flash_deal_id)->get());
    }
}
