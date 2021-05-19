<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App;

class Element extends Model
{
  use Sluggable;
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
    ];

    public $appends = [
        'thumbnaile_image'//, 'characteristicValues2'
    ];

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
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

    public function delete()
    {
        $this->combinations()->delete();
        $this->element_translations()->delete();
        return parent::delete();
    }
}
