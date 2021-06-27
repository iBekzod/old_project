<?php

namespace App;

use Cviebrock\EloquentSluggable\Services\SlugService;
use Cviebrock\EloquentSluggable\Sluggable;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variation extends Model
{
    protected $fillable = [
        'name',
        'lowest_price_id',
        'slug',
        'element_id',
        'prices',
        'variant',
        'partnum',
        'color_id',
        'photos',
        'characteristics',
        'user_id',
        'num_of_sale',
        'qty',
        'rating',
        'created_at',
        'updated_at',
        'deleted_at',

    ];

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

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? app()->getLocale() : $lang;
        $variation_translations = $this->variation_translations()->where('lang', $lang)->first();
        return $variation_translations != null ? $variation_translations->$field : $this->$field;
    }

     public function variation_translations()
     {
         return $this->hasMany(VariationTranslation::class);
     }

     public function element()
     {
         return $this->hasOne(Element::class, 'id', 'element_id');
     }

    public function product()
    {
        return $this->hasOne(Product::class, 'id','lowest_price_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function delete()
    {
        // return true;
        $this->products()->delete();
        // $this->variation_translations()->delete();
        return parent::delete();
    }

    public function save(array $options = [])
    {
       // before save code
        $result = parent::save($options);
        try{
            $variation=$this->variation;
            $color=Color::where('id', $variation->color_id)->first();
            $attributes=Characteristic::whereIn('id', explode(",", $variation->characteristics))->pluck('name');
            $variation_name=$variation->element->name;
            // dd( $attributes);
            foreach($attributes as $attribute){
                $variation_name=$variation_name.', '.$attribute;
            }
            if($color->name){
                $variation_name=$variation_name.', '.$color->name;
            }
            $variation->name=$variation_name;
            $variation->slug = SlugService::createSlug(Variation::class, 'slug', slugify($variation_name));
            $variation->save();
        }catch(Exception $e){
            // dd($e->getMessage());
        }
        foreach (Language::all() as $language) {
            $variation_translation = VariationTranslation::firstOrNew(['lang' => $language->code, 'variation_id' => $this->id]);
            $variation_translation->name = $this->name;
            $variation_translation->save();
        }
        // dd($variation);
       return $result; // do not ignore it eloquent calculates this value and returns this, not just to ignore

    }

    public function user()
     {
         return $this->belongsTo(User::class);
     }
}
