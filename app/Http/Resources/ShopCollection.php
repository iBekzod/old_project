<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ShopCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $arr = [
                    'name' => $data->name,
                    'logo' => api_asset($data->logo),
                    'sliders' => $this->convertPhotos(explode(',', $data->sliders)),
                    'address' => $data->address,
                    'facebook' => $data->facebook,
                    'google' => $data->google,
                    'twitter' => $data->twitter,
                    'youtube' => $data->youtube,
                    'instagram' => $data->instagram,
                    'slug' => $data->slug,
                    'links' => [
                        'featured' => route('shops.featuredProducts', $data->slug),
                        'top' => route('shops.topSellingProducts',  $data->slug),
                        'new' => route('shops.newProducts', $data->slug),
                        'all' => route('shops.allProducts', $data->slug),
                        'brands' => route('shops.brands', $data->slug)
                    ]
                ];

                if($data->user) {
                    $arr['user'] = [
                        'name' => $data->user->name,
                        'email' => $data->user->email,
                        'avatar' => $data->user->avatar,
                        'avatar_original' => $data->user->avatar_original
                    ];
                }

                return $arr;
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

    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item));
        }
        return $result;
    }
}
