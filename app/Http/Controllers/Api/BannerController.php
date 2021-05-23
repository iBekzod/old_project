<?php

namespace App\Http\Controllers\Api;

use App\Banner;
use App\Http\Resources\BannerCollection;

class BannerController extends Controller
{
    public function index()
    {
        // return json_decode(get_setting('home_slider_images', 'home_banner1_images'));
        $banners=Banner::whereIn('id', json_decode(get_setting('home_slider_images', 'home_banner1_images')))->get();
        return new BannerCollection($banners);
    }
}
