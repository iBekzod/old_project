<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductCollection;
use App\FlashDeal;
use App\Product;

class FlashDealsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    "title"=> $data->title,
                    "start_date"=> $data->start_date,
                    "end_date"=> $data->end_date,
                    "status"=> $data->status,
                    "featured"=> $data->featured,
                    "background_color"=> $data->background_color,
                    "text_color"=> $data->text_color,
                    "banner"=> api_asset($data->banner),
                    "slug"=> $data->slug,
                    "created_at"=> formatDate($data->created_at),
                    "updated_at"=> formatDate($data->updated_at),
                    "user_id"=> $data->user_id,
                    "on_moderation"=> $data->on_moderation
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
