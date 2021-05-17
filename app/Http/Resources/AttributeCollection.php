<?php

namespace App\Http\Resources;

use App\AttributeTranslation;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AttributeCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                $lang = AttributeTranslation::where('attribute_id', $data->id)->where('lang', app()->getLocale())->first();

                $arr =  [
                    'id'=>$data->id,
                    'name'=>$data->name,
                    'branch_id'=>$data->branch_id,
                   'combination'=>$data->combination
                ];

                if ($lang) {
                    $arr['name'] = $lang->name;
                }

                return $arr;
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
