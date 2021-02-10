<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerCollection;
use App\Http\Resources\SliderCollection;
use App\Models\BusinessSetting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Napa\R19\Sms;

class HomePageController extends Controller
{
    public function banners() {
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
    }

    public function homePageData() {
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
    }

    public function sendSMS(Request $request){
        // dd('test');
        // if($request->has('username'));
        return response()->json(Sms::send('998946071006', 'Your ashop.uz verification code '));
    }
    public function generateRandomOtp(){
        return rand(1000, 9999);
    }
}
