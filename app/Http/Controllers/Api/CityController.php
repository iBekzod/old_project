<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CityCollection;
use App\City;
use App\Country;
use App\Http\Resources\SearchCityCollection;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function cities($id)
    {
        return new CityCollection(City::where('country_id', $id)->get());
    }

    public function regions($country_id, $region_id)
    {
        return new CityCollection(City::where('country_id', $country_id)->where('parent_id', $region_id)->get());
    }
    public function countryRegions($country_id)
    {
        return new CityCollection(City::where('country_id', $country_id)->where('type', 'region')->get());
    }

    public function regionCities($region_id)
    {
        return new CityCollection(City::where('parent_id', $region_id)->whereIn('type', ['city', 'district'])->get());
    }

    public function countries()
    {
        return Country::where('status', 1)->get();
    }

    public function selectedCities(){
        return new SearchCityCollection(City::where('is_selected', true)->where('type', '<>','region')->inRandomOrder()->paginate(10));
    }

    public function search(Request $request){
        if($request->has('q') && $request->q!=null){
            $search_text=$request->q;
            return new SearchCityCollection(City::where('name', 'like', '%'.$search_text.'%')->where('type', '<>','region')->orWhereHas('parent', function ($relation) use ($search_text) {
                $relation->where('name', 'like', '%'.$search_text.'%');
            })->paginate(10));
        }
        return [];
    }
    
    public function getCurrentLocation(){
        $address=getUserAddress();
        return new SearchCityCollection(City::where('id', $address->city_id)->get());
    }

}
