<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Branch extends Model
{
    protected $fillable = [ 'name'];
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ?  app()->getLocale() : $lang;
        $branch_translation = $this->branch_translations()->where('lang', $lang)->first();
        return $branch_translation != null ? $branch_translation->$field : $this->$field;
    }

    public function branch_translations()
    {
        return $this->hasMany(BranchTranslation::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function delete()
    {
        if($attributes=$this->attributes()){
            foreach($attributes as $attribute){
                $attribute->branch_id=null;
            }
        }
        $this->branch_translations()->delete();
        return parent::delete();
    }
}
