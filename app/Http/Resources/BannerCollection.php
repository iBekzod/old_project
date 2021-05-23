<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BannerCollection extends ResourceCollection
{
    public function toArray($request)
    {
        // dd($request->all());
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'photo' => $data->photo ? api_asset($data->photo) : 'public/images/default-image.jpg',
                    'position' => $data->position,
                    'url' => $data->url ?? route('home'),

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
