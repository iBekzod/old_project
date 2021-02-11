<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'name' => $data->name,
                    'type' => $data->user_type,
                    'email' => $data->email,
                    'avatar' => $data->avatar,
                    'avatar_original' => api_asset($data->avatar_original),
                    'address' => $data->address,
                    'city' => $data->city,
                    'country' => $data->country,
                    'postal_code' => $data->postal_code,
                    'phone' => $data->phone,
                    'full_name' => $data->full_name,
                    'profile_image' => $data->profile_image,
                    'date_of_birth' => $data->date_of_birth,
                    'gender' => $data->gender,
                    'full_address' => $data->full_address,
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
