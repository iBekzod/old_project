<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ClubPointCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id'=>$data->id,
                    'points' => $data->points, // ball soma
                    'convert_status' => $data->convert_status,
                    'created_at' => formatDate($data->created_at), // data
                    'club_point_details'=>$data->clubPointDetails
                ];
            }),
            'total'=>$this->collection->sum('points')
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

