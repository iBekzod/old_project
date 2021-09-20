<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'ticket_replies'=>$data->ticketreplies,
                    'subject' => $data->subject,
                    'details' => $data->details,
                    'files' => $data->files,
                    'status' => $data->status,
                    'viewed' => $data->viewed,
                    'client_viewed' => $data->client_viewed,
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

