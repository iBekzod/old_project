<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchCityCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $parent_name="";
                if($data->parent()->exists()){
                    $parent_name=($data->parent->getTranslation('name'));
                }
                return [
                    'id' => $data->id,
                    'name' => $data->getTranslation('name').', '.$parent_name,
                    'country_id' => $data->country_id,
                    'type' => $data->type,
                    'parent_id' => $data->parent_id,
                    'distance' => $data->distance,
                    // 'longitude'=>$data->longitude,
                    // 'latitude'=>$data->latitude,
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
