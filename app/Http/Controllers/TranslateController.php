<?php

namespace App\Http\Controllers;

use App\Translation;
use Dejurin\GoogleTranslateForFree;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    public function index(){
        $source = 'en';
        $target = 'uz';
        $attempts = 5;
        $arr = [];
        $contents = Translation::where('lang', $source)->limit(10)->get();
        foreach ($contents as $content){
            array_push($arr, $content->lang_key);
        }

        $tr = new GoogleTranslateForFree();
        $result = $tr->translate($source, $target, $arr, $attempts);

        dd($result);
    }

}
