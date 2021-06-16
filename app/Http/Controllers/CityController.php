<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Country;
use App\CityTranslation;
use App\Language;
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::orderBy('name', 'asc')->paginate(15);
        $all_cities = City::all();
        $countries = Country::where('status', 1)->get();
        return view('backend.setup_configurations.cities.index', compact('cities', 'all_cities', 'countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $city = City::firstOrNew([
            'country_id'=>$request->country_id,
            'parent_id'=>$request->region_id,
            'distance'=>$request->distance,
            'name'=>$request->name,
            'type'=>$request->type
        ]);
        // $city = new City;
        // $city->country_id = $request->country_id;
        // $city->parent_id = $request->region_id;
        // $city->distance = $request->distance;
        // $city->name = $request->name;
        // $city->type = $request->type;
        // $city->save();
        if($city->save()){
            foreach (Language::all() as $language){
                // City Translations
                $city_translation = CityTranslation::firstOrNew(['lang' => $language->code, 'city_id' => $city->id]);
                $city_translation->name = $city->name;
                $city_translation->save();
            }
        }

        flash(translate('City has been inserted successfully'))->success();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request, $id)
     {
         $lang  = $request->lang;
         $city  = City::findOrFail($id);
         $countries = Country::where('status', 1)->get();
         $all_cities = City::all();
         return view('backend.setup_configurations.cities.edit', compact('city', 'all_cities', 'lang', 'countries'));
     }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $city = City::findOrFail($id);
        // if($request->lang == default_language()){
        //     $city->name = $request->name;
        // }

        $city->country_id = $request->country_id;
        $city->parent_id = $request->region_id;
        $city->distance = $request->distance;
        $city->name = $request->name;
        $city->type = $request->type;
        $city->save();

        if(CityTranslation::where('city_id' , $city->id)->where('lang' ,default_language())->first()){
            foreach (Language::all() as $language){
                $city_translation = CityTranslation::firstOrNew(['lang' => $language->code, 'city_id' => $city->id]);
                $city_translation->name = $request->name;
                $city_translation->save();
            }
        }

        flash(translate('City has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);

        foreach ($city->city_translations as $key => $city_translation) {
            $city_translation->delete();
        }

        City::destroy($id);

        flash(translate('City has been deleted successfully'))->success();
        return redirect()->route('cities.index');
    }
}
