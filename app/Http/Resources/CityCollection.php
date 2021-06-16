<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => $data->id,
                    'name' => $data->getTranslation('name'),
                    'country_id' => $data->country_id,
                    'type' => $data->type,
                    'parent_id' => $data->parent_id,
                    'distance' => $data->distance,
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
