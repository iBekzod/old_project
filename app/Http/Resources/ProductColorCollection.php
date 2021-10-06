<?php

namespace App\Http\Resources;

use App\Color;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductColorCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function($data) {
            if($color=Color::where('id', $data)->firstOrFail()){
                $arr = [
                    'id'=>$color->id,
                    'hash' => $color->code,
                    'name' => $color->getTranslation('name', app()->getLocale())
                ];
            }else{
                $arr = [
                    'id'=>null,
                    'hash' => null,
                    'name' => null
                ];
            }
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
