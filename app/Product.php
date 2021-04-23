<?php

namespace App;

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
        'element_id',
        'todays_deal',
        'delivery_group_id',
        'qty',
        'published',
        'tax',
        'tax_type',
        'created_at',
        'updated_at',
    ];

    // protected $fillable = [
    //     'name', 'added_by', 'user_id', 'category_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
    //     'purchase_price', 'unit', 'slug', 'colors', 'choice_options', 'variations', 'current_stock', 'on_moderation',
    //     'is_accepted'
    // ];

    // public $appends = [
    //     'thumbnaile_image', 'characteristicValues2'
    // ];

    // public function characteristicValues()
    // {
    //     return $this->hasMany(App\Models\CharacteristicValues::class, 'product_id', 'id');
    // }

    // public function getTranslation($field = '', $lang = false)
    // {
    //     $lang = $lang == false ? App::getLocale() : $lang;

    //     $product_translations = $this->product_translations()->where('lang', $lang)->get();

    //     if ((int)$product_translations->count()) {
    //         return isset($product_translations[0]) ? $product_translations[0]->{$field} : $this->{$field};
    //     } else {
    //         return $this->{$field};
    //     }
    // }

    // public function product_translations()
    // {
    //     return $this->hasMany(ProductTranslation::class);
    // }

    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }

    // public function parentHierarchy()
    // {
    //     return $this->hasOne(Category::class, 'id', 'category_id')->with('parentCategoryHierarchy');
    // }

    // public function brand()
    // {
    //     return $this->belongsTo(Brand::class);
    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function orderDetails()
    // {
    //     return $this->hasMany(OrderDetail::class);
    // }

    // public function reviews()
    // {
    //     return $this->hasMany(Review::class)->where('status', 1);
    // }

    // public function wishlists()
    // {
    //     return $this->hasMany(Wishlist::class);
    // }

    // public function stocks()
    // {
    //     return $this->hasMany(ProductStock::class)->with('product');
    // }

    // public function getThumbnaileImageAttribute()
    // {
    //     return api_asset($this->thumbnail_img);
    // }

    // public function getCharacteristicValues2Attribute()
    // {
    //     $arr = [];

    //     foreach ($this->characteristicValues as $key => $item) {
    //         $attr = App\Models\ProductAttributeCharacteristics::where('id', $item->attr_id)->with('values')->first();

    //         $arr[$key] = [
    //             'attr_id' => $item->attr_id,
    //             'parent_id' => $item->parent_id,
    //             'key' => $item->name,
    //             'value' => $item->values,
    //             'values' => array_map(function ($el) {
    //                 return [
    //                     'id' => $el,
    //                     'text' => $el,
    //                     'selected' => true
    //                 ];
    //             }, explode(' / ', $item->values))
    //         ];

    //         if ($attr) {
    //             if ($attr->values->count()) {
    //                 foreach ($attr->values as $value) {
    //                     if (!in_array($value->value, explode(' / ', $item->values))) {
    //                         array_push($arr[$key]['values'], [
    //                             'id' => $value->value,
    //                             'text' => $value->value
    //                         ]);
    //                     }
    //                 }
    //             }
    //         }
    //     }

    //     return $arr;
    // }

    // public function productAttributes()
    // {
    //     return $this->belongsToMany(ProductAttribute::class,
    //         'product_product_attributes',
    //         'product_id',
    //         'product_attribute_id'
    //     );
    // }

    // public function getCharacteristicValuesForDetailProductAttribute()
    // {
    //     $arr = collect();

    //     foreach ($this->characteristicValues as $item) {
    //         $arr->push([
    //             'parent_id' => $item->parent_id,
    //             'attribute_id' => $item->attr_id,
    //             'attribute' => App\Models\ProductAttributeCharacteristics::where('id', $item->attr_id)->first(),
    //             'key' => $item->name,
    //             'value' => $item->values
    //         ]);
    //     }

    //     $parents = collect();

    //     foreach ($arr->groupBy('parent_id') as $key => $val) {
    //         $parents[] = App\Models\ProductAttribute::where('id', $key)->first();
    //     }

    //     return [
    //         'attrs' => $arr,
    //         'parents' => $parents
    //     ];
    // }
}
