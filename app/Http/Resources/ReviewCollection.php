<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'product'=>[
                        'id'=>$data->product->id,
                        'slug'=>$data->product->slug,
                        'name'=>$data->product->name,
                        'seller'=>$data->product->user->user_type,
                        'seller_name'=>$data->product->user->user_type=='admin'?'admin':$data->product->user->name,
                    ],
                    'user' => [
                        'name' => $data->user->name,
                        'email' => $data->user->email,
                        'phone' => $data->user->phone,
                        'avatar' => $data->user->avatar,
                        'avatar_original' => api_asset($data->user->avatar_original),
                    ],
                    'rating' => $data->rating,
                    'comment' => $data->comment,
                    'time' => $data->created_at->diffForHumans()
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
