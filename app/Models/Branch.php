<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
class Branch extends Model
{
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $branch_translation = $this->branch_translations()->where('lang', $lang)->first();
        return $branch_translation != null ? $branch_translation->$field : $this->$field;
    }

    public function branch_translations()
    {
        return $this->hasMany(BranchTranslation::class);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class,'attribute_id', 'id');
    }
}
