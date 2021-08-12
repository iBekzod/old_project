<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Country;
use App\CityTranslation;
use App\Language;
class CityController extends Controller
{
    public function regions($country_id, $region_id)
    {
        $regions=(City::where('country_id', $country_id)->where('parent_id', $region_id)->get());
        return $regions;
    }

    public function countries()
    {
        return Country::where('status', 1)->get();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cities = City::orderBy('name', 'asc');
        $sort_search=null;
        if($request->has('search') && $request->search!=null){
            $cities=$cities->where('name', 'like', '%'.$request->search.'%');
            $sort_search=$request->search;
        }
        $cities=$cities->paginate(15);
        $all_cities = City::all();
        $countries = Country::where('status', 1)->get();
        return view('backend.setup_configurations.cities.index', compact('cities', 'all_cities', 'countries', 'sort_search'));
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
            'type'=>$request->type,
        ]);
        $city->distance = $request->distance;
        $city->name = $request->name;
        $city->distance = $request->distance;
        $city->inside_price = $request->inside_price;
        $city->has_express = $request->has_express=='on';
        $city->is_selected = $request->is_selected=='on';
        if($city->save()){
            foreach (Language::all() as $language){
                // City Translations
                $city_translation = CityTranslation::firstOrNew(['lang' => $language->code, 'city_id' => $city->id]);
                $city_translation->name = $city->name;
                $city_translation->save();
            }
        }

        flash(translate('City has been inserted successfully'))->success();

        return $this->index();
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
        $city->inside_price=$request->inside_price;
        $city->has_express=$request->has_express=='on';
        $city->is_selected=$request->is_selected=='on';
        $city->save();

        if(CityTranslation::where('city_id' , $city->id)->where('lang' ,default_language())->first()){
            foreach (Language::all() as $language){
                $city_translation = CityTranslation::firstOrNew(['lang' => $language->code, 'city_id' => $city->id]);
                $city_translation->name = $request->name;
                $city_translation->save();
            }
        }

        flash(translate('City has been updated successfully'))->success();
        return $this->index();
    }

    public function updateExpress(Request $request)
    {
        $city = City::findOrFail($request->id);
        $city->has_express = $request->status;
        if ($city->save()) {
            if($city->type=='region'){
                City::where('parent_id', $city->id)->update(['has_express' => true]);
            }
            return 1;
        }
        return 0;
    }

    public function updateSelected(Request $request)
    {
        $city = City::findOrFail($request->id);
        $city->is_selected = $request->status;
        if ($city->save()) {
            if($city->type=='region'){
                City::where('parent_id', $city->id)->update(['has_express' => true]);
            }
            return 1;
        }
        return 0;
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
        return $this->index();
    }
}
