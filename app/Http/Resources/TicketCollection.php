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
                    'code'=>$data->code,
                    'ticket_replies'=>new TicketReplyCollection($data->ticketreplies),
                    'subject' => $data->subject,
                    'details' => $data->details,
                    'files' => $data->files,
                    'status' => $data->status,
                    'viewed' => $data->viewed,
                    'client_viewed' => $data->client_viewed,
                    'created_at'=>formatDate($data->created_at),
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

