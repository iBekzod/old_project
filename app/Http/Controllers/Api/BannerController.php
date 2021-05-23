<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Http\Resources\BannerCollection;
use App\Http\Resources\BannerSliderCollection;
use App\Http\Resources\SliderCollection;

class BannerController extends Controller
{
    public function index()
    {
        try {
            $sliders=new SliderCollection(json_decode(get_setting('home_slider_images'), true));
            $bannerHorizontal = new BannerCollection(json_decode(get_setting('home_banner_horizontal_images'), true));
            $bannerVertical = new BannerCollection(json_decode(get_setting('home_banner_vertical_images'), true));
            $bannerSquare = new BannerCollection(json_decode(get_setting('home_banner_square_images'), true));
            return response()->json([
                'sliders' => $sliders,
                'bannerHorizontal' => $bannerHorizontal,
                'bannerVertical' => $bannerVertical,
                'bannerSquare' => $bannerSquare
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: '.$e->getMessage()
            ]);
        }
        // $banner_image_ids = json_decode(get_setting('home_slider_images', 'home_banner1_images'), true);
        // if(is_array($banner_image_ids)){
        //     return $this->convertPhotos($banner_image_ids);
        // }else{
        //     return null;
        // }
    }


    protected function convertPhotos($data){
        $result = array();
        foreach ($data as $key => $item) {
            array_push($result, api_asset($item)??static_asset('assets/img/placeholder.jpg'));
        }
        return $result;
    }
}
