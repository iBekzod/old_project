<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Element extends Model
{
  use Sluggable;
  use SoftDeletes;
  public function sluggable(): array
  {
      return [
          'slug' => [
              'source' => 'name'
          ]
      ];
  }
    protected $fillable = [
        'name',
        'added_by',
        'user_id',
        'category_id',
        'brand_id',
        'photos',
        'thumbnail_img',
        'video_provider',
        'video_link',
        'tags',
        'description',
        'attribute_list',
        'choice_options',
        'characteristic_list',
        'colors',
        'todays_deal',
        'published',
        'featured',
        'unit',
        'weight',
        'min_qty',
        'num_of_sale',
        'meta_title',
        'meta_description',
        'meta_img',
        'pdf',
        'slug',
        'refundable',
        'earn_point',
        'rating',
        'barcode',
        'digital',
        'file_name',
        'file_path',
        'created_at',
        'updated_at',
        'on_moderation',
        'is_accepted',
        'deleted_at',
    ];

    public $appends = [
        'thumbnaile_image'//, 'characteristicValues2'
    ];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? app()->getLocale() : $lang;
        $element_translations = $this->element_translations()->where('lang', $lang)->first();
        return $element_translations != null ? $element_translations->$field : $this->$field;
    }
    public function element_translations()
    {
        return $this->hasMany(ElementTranslation::class, 'element_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getThumbnaileImageAttribute()
    {
        return api_asset($this->thumbnail_img);
    }

    public function combinations()
    {
        return $this->hasMany(Variation::class, 'element_id', 'id');
    }


    public function products()
    {
        return $this->hasMany(Product::class, 'element_id', 'id');
    }

    public function delete()
    {
        if($this->parent_id==null){
            if($element=Element::where('parent_id', $this->id)->first()){
                $element->parent_id=null;
                $element->save();
            }
        }
        // foreach($this->products() as $product){
        //     $product->published=0;

        //     // $product->added_by="deleted";
        // }
        // $this->added_by="deleted";
        // $this->save();
        // $this->element_translations()->delete();
        // $this->combinations()->delete();
        // dd($this);
        return parent::delete();
    }

    public function parentHierarchy()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function save(array $options = [])
    {
       // before save code
        $result = parent::save($options);
        foreach (Language::all() as $language) {
            // Element Translations
            $element_translation = ElementTranslation::firstOrNew(['lang' => $language->code, 'element_id' => $this->id]);
            $element_translation->name = $this->name;
            $element_translation->unit = $this->unit;
            $element_translation->description = $this->description;
            $element_translation->save();
        }
        // dd($variation);
       return $result; // do not ignore it eloquent calculates this value and returns this, not just to ignore

    }


}
