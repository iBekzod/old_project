<?php

namespace App\Http\Controllers\Api;

use App\Attribute;
use App\Frontend;
use App\FrontendTranslation;
use App\Category;
use Illuminate\Http\Request;
use App\Language;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    public function getFrontendTranslation(Request $request)
    {
        if($frontend=Frontend::where('name', $request->name)->first()){
            // return $frontend->getTranslation('name');
            return response()->json([
                'success' => true,
                'name' => $frontend->getTranslation('name')
            ]);
        }else{
            $frontend = Frontend::firstOrNew(['name' => $request->name]);
            $frontend->type=$request->type??'web';
            $frontend->save();
            foreach (Language::all() as $language){
                // Frontend  Translation
                $frontend_translation = FrontendTranslation::firstOrNew(['lang' => $language->code, 'frontend_id' => $frontend->id]);
                $frontend_translation->name = $frontend->name;
                $frontend_translation->save();
            }
            // return $frontend->getTranslation('name');
            return response()->json([
                'success' => false,
                'name' => $frontend->getTranslation('name')
            ]);
        }
    }

    public function getWeb(Request $request)
    {
        return Frontend::where('type', 'web')->get();
    }

    public function getMobile(Request $request)
    {
        return Frontend::where('type', 'mobile')->get();
    }
}
