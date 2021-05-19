<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App;
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
        $lang = $lang == false ? App::getLocale() : $lang;
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

     public function delete()
    {
        $this->reviews()->delete();
        $this->wishlists()->delete();
        $this->product_translations()->delete();
        return parent::delete();
    }
}
