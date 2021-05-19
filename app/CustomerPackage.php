<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CustomerPackage extends Model
{
    public function getTranslation($field = '', $lang = false){
      $lang = $lang == false ? app()->getLocale() : $lang;
      $customer_package_translation = $this->customer_package_translations()->where('lang', $lang)->first();
      return $customer_package_translation != null ? $customer_package_translation->$field : $this->$field;
    }

    public function customer_package_translations(){
      return $this->hasMany(CustomerPackageTranslation::class);
    }

    public function customer_package_payments()
    {
        return $this->hasMany(CustomerPackagePayment::class);
    }

}
