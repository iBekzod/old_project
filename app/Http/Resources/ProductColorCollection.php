<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductColorCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function($data) {
            $arr = [
                'hash' => $data,
                'name' => \App\Color::where('code', $data)->first()->getTranslation('name')
            ];
          //  TODO::name ni bir korish kere

            return $arr;
        });
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
