<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ConversationCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'sender_id' => $data->sender_id,
                    'receiver_id' => $data->receiver_id,
                    'title' => $data->title,
                    'sender_viewed' => $data->sender_viewed,
                    'receiver_viewed' => $data->receiver_viewed,
                    'created_at' => $data->created_at,
                    'updated_at' => $data->updated_at
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
