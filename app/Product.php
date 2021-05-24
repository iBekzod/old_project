<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'user_id',
        'added_by',
        'currency_id',
        'price',
        'discount',
        'discount_type',
        'variation_id',
        'todays_deal',
        'num_of_sale',
        'delivery_group_id',
        'qty',
        'published',
        'tax',
        'tax_type',
        'featured',
        'seller_featured',
        'on_moderation',
        'is_accepted',
        'rating',
        'barcode',
        'earn_point',
        'created_at',
        'updated_at',
    ];

    use Sluggable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    // protected $fillable = [
    //     'name', 'added_by', 'user_id', 'category_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
    //     'purchase_price', 'unit', 'slug', 'colors', 'choice_options', 'variations', 'current_stock', 'on_moderation',
    //     'is_accepted'
    // ];

//     public $appends = [
//         'thumbnaile_image'
//     ];

    // public function characteristicValues()
    // {
    //     return $this->hasMany(App\Models\CharacteristicValues::class, 'product_id', 'id');
    // }


    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? app()->getLocale() : $lang;
        $product_translations = $this->product_translations()->where('lang', $lang)->first();
        return $product_translations != null ? $product_translations->$field : $this->$field;
    }

     public function product_translations()
     {
         return $this->hasMany(ProductTranslation::class);
     }

     public function user()
     {
         return $this->belongsTo(User::class);
     }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }

     public function orderDetails()
     {
         return $this->hasMany(OrderDetail::class);
     }

     public function reviews()
     {
         return $this->hasMany(Review::class)->where('status', 1);
     }

     public function wishlists()
     {
         return $this->hasMany(Wishlist::class);
     }

     public function element()
    {
        return $this->hasOneThrough(
            Element::class,
            Variation::class
        );
    }

     public function delete()
    {
        $this->reviews()->delete();
        $this->wishlists()->delete();
        $this->product_translations()->delete();
        return parent::delete();
    }


    // public function save(array $options = [])
    // {

    //    // before save code
    //     $result = parent::save($options); // returns boolean
    //     // after save code
    //     $variation=$this->variation;
    //     $products = Product::where('name', $variation->name)->where('variation_id', $variation->id);
    //     // dd($products);
    //     if(count($products->get())>1){
    //         $min_price=$products->min("price");
    // $lowest_price_list=$products->where('price', $min_price)->pluck('id');
    // $lowest_price_id=$lowest_price_list[rand(0, count($lowest_price_list)-1)];
    // $variation->lowest_price_id=$lowest_price_id;
    //         $variation->qty=$products->sum('qty');
    //         $variation->num_of_sale=$products->sum('num_of_sale');
    //         $variation->prices=$products->pluck('price');
    //         $variation->rating=(double)$products->sum('rating')/$products->count();
    //     }
    //     // dd($variation);
    //    return $result; // do not ignore it eloquent calculates this value and returns this, not just to ignore

    // }
}
