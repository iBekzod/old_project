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
                return [
                    //'branchs'=> new BranchCollection($data->branch),
                    'id'=>$data->id,
                    'name'=>$data->getTranslation('name'),
                    'branch_id'=>$data->branch_id,
                    'combination'=>$data->combination
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
