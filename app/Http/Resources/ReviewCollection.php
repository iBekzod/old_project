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
                    'user' => [
                        'name' => $data->user->name,
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
            'success' => true,
            'status' => 200
        ];
    }
}
