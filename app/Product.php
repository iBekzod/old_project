<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
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
        'element_id',
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
        'deleted_at',
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

    public $appends = [
        'currency_rate', 'address'
    ];

    // public function characteristicValues()
    // {
    //     return $this->hasMany(App\Models\CharacteristicValues::class, 'product_id', 'id');
    // }

    // public function parentHierarchy()
    // {
    //     return $this->hasOne(Category::class, 'id', 'category_id')->with('parentCategoryHierarchy');
    // }

    public function getCurrencyRateAttribute()
    {
        return $this->price/$this->currency->exchange_rate;
    }

    public function getAddressAttribute()
    {
        return $this->user->addresses->first();
    }

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

    //  public function brand()
    //  {
    //      return $this->element->brand;
    //  }

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
        return $this->belongsTo(Element::class, 'element_id', 'id');
    }

     public function delete()
    {
        // $this->published=false;
        // $this->added_by="deleted";
        // $this->save();

        // $this->reviews()->delete();
        // $this->wishlists()->delete();
        // $this->product_translations()->delete();
        return parent::delete();
    }


    public function save(array $options = [])
    {
       // before save code
        $result = parent::save($options);
        try{
            $variation=$this->variation;
            $products = Product::where('variation_id', $variation->id)->where('published', true);
            if(count($products->get())>0){
                $min_price=$products->min("price");
                $lowest_price_list=$products->where('price', $min_price)->pluck('id');
                $lowest_price_id=$lowest_price_list[rand(0, count($lowest_price_list)-1)];
                $variation->lowest_price_id=$lowest_price_id;
                $variation->qty=$products->sum('qty');
                $variation->num_of_sale=$products->sum('num_of_sale');
                $variation->prices=$products->pluck('price');
                $variation->rating=(double)$products->sum('rating')/$products->count();
                $variation->save();
            }
        }catch(Exception $e){
            // dd($e->getMessage());
        }

        foreach (Language::all() as $language) {
            // Product Translations
            $product_translation = ProductTranslation::firstOrNew(['lang' => $language->code, 'product_id' => $this->id]);
            $product_translation->name = $this->name;
            $product_translation->save();
        }
        // dd($variation);
       return $result; // do not ignore it eloquent calculates this value and returns this, not just to ignore

    }
}
