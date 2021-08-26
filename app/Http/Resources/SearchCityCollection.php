<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchCityCollection extends ResourceCollection
{
    public function toArray($request)
    {
        // dd($this->collection->get());
        return [
            'data' => $this->collection->map(function($data) {
                $parent_name="";
                if($data->parent()->exists()){
                    $parent_name=($data->parent->getTranslation('name'));
                }
                $longitude=getDefaultLongitude();
                $latitude=getDefaultLatitude();
                if(isset($data->address)){
                    $longitude=json_decode($data->address)->longitude??getDefaultLongitude();
                    $latitude=json_decode($data->address)->latitude??getDefaultLatitude();
                }
                $is_registred=true;
                if(isset($data->is_registered)){
                    $is_registred=(bool)$data->is_registered;
                }

                return [
                    'id' => $data->id,
                    'name' => $data->getTranslation('name').', '.$parent_name,
                    'country_id' => $data->country_id,
                    'type' => $data->type,
                    'parent_id' => $data->parent_id,
                    'distance' => $data->distance,
                    'longitude'=>$longitude,
                    'latitude'=>$latitude,
                    'is_registered'=>$is_registred
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'lang'=> app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }
}
