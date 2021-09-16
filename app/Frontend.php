<?php

namespace App;
use App;
use Illuminate\Database\Eloquent\Model;
class Frontend extends Model
{
    protected $fillable = [ 'name', 'type'];
    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ?  App::getLocale() : $lang;
        if($ip_address=IpAddress::where('ip', getClientIp())->first()){
            if($ip_address->language_id!=null && $ip_address->language()->exists()){
                $lang =$ip_address->language->code;
            }
        }
        // dd($ip_address);
        $frontend_translation = $this->frontend_translations()->where('lang', $lang)->first();
        return $frontend_translation != null ? $frontend_translation->$field : $this->$field;
    }

    public function frontend_translations()
    {
        return $this->hasMany(FrontendTranslation::class);
    }

    public function delete()
    {
        $this->frontend_translations()->delete();
        return parent::delete();
    }
}
