<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Product extends Model
{
    protected $fillable = [
        'name','added_by', 'user_id', 'category_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
        'purchase_price', 'unit', 'slug', 'colors', 'choice_options', 'variations', 'current_stock'
    ];

    public $appends = [
        'thumbnaile_image', 'characteristicValues2'
    ];

    public function characteristicValues()
    {
        return $this->hasMany(App\Models\CharacteristicValues::class, 'product_id', 'id');
    }

    public function getTranslation($field = '', $lang = false){
      $lang = $lang == false ? App::getLocale() : $lang;
      $product_translations = $this->hasMany(ProductTranslation::class)->where('lang', $lang)->first();
      return $product_translations != null ? $product_translations->$field : $this->$field;
    }

    public function product_translations(){
    	return $this->hasMany(ProductTranslation::class);
    }

    public function category(){
    	return $this->belongsTo(Category::class);
    }

    public function brand(){
    	return $this->belongsTo(Brand::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function orderDetails(){
    return $this->hasMany(OrderDetail::class);
    }

    public function reviews(){
    return $this->hasMany(Review::class)->where('status', 1);
    }

    public function wishlists(){
    return $this->hasMany(Wishlist::class);
    }

    public function stocks(){
        return $this->hasMany(ProductStock::class)->with('product');
    }

    public function getThumbnaileImageAttribute()
    {
        return api_asset($this->thumbnail_img);
    }

    public function getCharacteristicValues2Attribute()
    {
        $arr = [];
        foreach ($this->characteristicValues as $item) {
            $arr[] = [
                'attr_id' => $item->attr_id,
                'parent_id' => $item->parent_id,
                'key'          => $item->name,
                'value'        => $item->values
            ];
        }
        return $arr;
    }

    public function getCharacteristicValuesForDetailProductAttribute()
    {
        $arr = collect();

        foreach ($this->characteristicValues as $item) {
            $arr->push([
                'parent_id' => $item->parent_id,
                'attribute_id' => $item->attr_id,
                'attribute' => App\Models\ProductAttributeCharacteristics::where('id', $item->attr_id)->first(),
                'key'         => $item->name,
                'value'        => $item->values
            ]);
        }

        $arr = $arr->groupBy('parent_id');

        $parents = collect();

        foreach ($arr as $key => $val)
        {
            $parents[] = App\Models\ProductAttribute::where('id', $key)->first();
        }

        return [
            'attrs' => $arr,
            'parents' => $parents
        ];
    }
}
