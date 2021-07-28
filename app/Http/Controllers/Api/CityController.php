<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CityCollection;
use App\City;
use App\Country;

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

}
