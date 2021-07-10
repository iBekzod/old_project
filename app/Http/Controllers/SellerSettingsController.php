<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SellerSetting;

class SellerSettingsController extends Controller
{

    public function smtp_settings(Request $request)
    {
        // CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.smtp_settings');
    }



    public function payment_method(Request $request)
    {
        // CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.payment_method');
    }

    public function file_system(Request $request)
    {
        // CoreComponentRepository::instantiateShopRepository();
        return view('backend.setup_configurations.file_system');
    }

    /**
     * Update the API key's for payment methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_method_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
        }

        $seller_settings = SellerSetting::where('user_id', auth()->id())->where('type', $request->payment_method.'_sandbox')->first();
        // dd($seller_settings->type);
        if($request->has('relation_id')){
            $seller_settings->relation_id = $request->relation_id;
        }
        if($seller_settings != null){
            if ($request->has($request->payment_method.'_sandbox')) {
                $seller_settings->value = 1;
                $seller_settings->save();
            }
            else{
                $seller_settings->value = 0;
                $seller_settings->save();
            }
        }

        flash(translate("Settings updated successfully"))->success();
        return back();
    }

    /**
     * Update the API key's for other methods.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function env_key_update(Request $request)
    {
        foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
        }

        flash(translate("Settings updated successfully"))->success();

        return back();
    }

    /**
     * overWrite the Env File values.
     * @param  String type
     * @param  String value
     * @return \Illuminate\Http\Response
     */
    public function overWriteEnvFile($type, $val)
    {
        if(env('DEMO_MODE') != 'On'){
            $path = base_path('.env');
            if (file_exists($path)) {
                $val = '"'.trim($val).'"';
                if(is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0){
                    file_put_contents($path, str_replace(
                        $type.'="'.env($type).'"', $type.'='.$val, file_get_contents($path)
                    ));
                }
                else{
                    file_put_contents($path, file_get_contents($path)."\r\n".$type.'='.$val);
                }
            }
        }
    }

    public function update(Request $request)
    {
        foreach ($request->types as $key => $type) {
            if($type == 'site_name'){
                $this->overWriteEnvFile('APP_NAME', $request[$type]);
            }
            if($type == 'timezone'){
                $this->overWriteEnvFile('APP_TIMEZONE', $request[$type]);
            }
            else {
                $seller_settings = SellerSetting::where('user_id', auth()->id())->where('type', $type)->first();
                if($request->has('relation_id')){
                    $seller_settings->relation_id = $request->relation_id;
                }
                if($seller_settings!=null){
                    if(gettype($request[$type]) == 'array'){
                        $seller_settings->value = json_encode($request[$type]);
                    }
                    else {
                        $seller_settings->value = $request[$type];
                    }
                    $seller_settings->save();
                }
                else{
                    $seller_settings = new SellerSetting;
                    $seller_settings->user_id = auth()->id();
                    $seller_settings->type = $type;
                    if(gettype($request[$type]) == 'array'){
                        $seller_settings->value = json_encode($request[$type]);
                    }
                    else {
                        $seller_settings->value = $request[$type];
                    }
                    $seller_settings->save();
                }
            }
        }
        flash(translate("Settings updated successfully"))->success();
        return back();
    }


    public function shipping_configuration(Request $request){
        return view('backend.setup_configurations.shipping_configuration.index');
    }

    public function seller_configuration_update(Request $request){
        $seller_settings = SellerSetting::where('user_id', auth()->id())->where('type', $request->type)->first();
        $seller_settings->value = $request[$request->type];
        if($request->has('relation_id')){
            $seller_settings->relation_id = $request->relation_id;
        }
        $seller_settings->save();
        return back();
    }


}
