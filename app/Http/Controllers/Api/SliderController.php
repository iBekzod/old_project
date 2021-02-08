<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SliderCollection;

class SliderController extends Controller
{
    public function index()
    {
        try {
        return new SliderCollection(json_decode(get_setting('home_slider_images'), true));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage()
            ]);
        }      
    }
}
