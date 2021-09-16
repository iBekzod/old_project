<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Language;
use App;
use App\Http\Resources\LanguageCollection;
use App\IpAddress;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        App::setLocale($request->locale);
        // $request->session()->put('locale', $request->locale);
        if($language = Language::where('code', $request->locale)->first()){
            $ip_address=IpAddress::firstOrNew(['ip', getClientIp()]);
            $ip_address->language_id=$language->id;
            return response()->json([
                'success' => true,
                'message' => translate('Language changed to ') .' '. $language->name
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Not found'
        ]);
    }

    public function index()
    {
        $languages = Language::all();
        return new LanguageCollection($languages);
    }
}
