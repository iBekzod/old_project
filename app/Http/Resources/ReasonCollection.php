<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReasonCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    'name' => $data->getTranslation('name'),
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'lang'=>app()->getLocale(),
            'success' => true,
            'status' => 200
        ];
    }
}

