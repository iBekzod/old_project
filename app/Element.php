<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

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
        'attributes',
        'choice_options',
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

//    public $appends = [
//        'thumbnaile_image', 'characteristicValues2'
//    ];
}
