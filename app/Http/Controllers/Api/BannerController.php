<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Http\Resources\BannerSliderCollection;

class BannerController extends Controller
{
    public function index()
    {
        $banner_image_ids = json_decode(get_setting('home_slider_images', 'home_banner1_images'), true);
        if(is_array($banner_image_ids)){
            return $this->convertPhotos($banner_image_ids);
        }else{
            return null;
        }


        // if(is_array($banner_image_ids)){
        //     $banners=Banner::whereIn('id', $banner_image_ids)->where('published', true)->get();
        //     return new BannerSliderCollection($banners);
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
