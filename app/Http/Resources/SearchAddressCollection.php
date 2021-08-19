<?php

namespace App\Http\Resources;

use App\Address;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchAddressCollection extends ResourceCollection
{
    public function toArray($request)
    {
        $addresses=Address::where('id',$this->collection->first()->id)->get();
        return [
            'data' => $addresses->map(function($data) {
                return [
                    'id' => $data->city_id,
                    'name' => $data->city->getTranslation('name').', '.$data->region->getTranslation('name'),
                    'country_id' => $data->city->country_id,
                    'type' => $data->city->type,
                    'parent_id' => $data->city->parent_id,
                    'distance' => $data->city->distance,
                    'longitude'=>$data->longitude,
                    'latitude'=>$data->latitude,
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
