<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Http\Resources\BannerCollection;

class BannerController extends Controller
{
    public function index()
    {
        $banner_image_ids = json_decode(get_setting('home_slider_images', 'home_banner1_images'), true);
        // return $banner_image_ids;
        if(is_array($banner_image_ids)){
            $banners=Banner::whereIn('id', $banner_image_ids)->where('published', true)->get();
            return new BannerCollection($banners);
        }else{
            return null;
        }


    }
}
