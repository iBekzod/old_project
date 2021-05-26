<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductColorCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function($data) {
            $color=\App\Color::where('id', $data)->first();
            $arr = [
                'hash' => $color->code,
                'name' => $color->getTranslation('name')
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
