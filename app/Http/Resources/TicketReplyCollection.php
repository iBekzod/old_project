<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketReplyCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    'ticket_id'=> $data->ticket_id,
                    'user' => [
                        'type'=>$data->user->user_type,
                        'name'=>$data->user->full_name??$data->user->name
                    ],
                    'reply' => $data->reply,
                    'files' => $data->files,
                    'created_at'=>$data->created_at,
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

