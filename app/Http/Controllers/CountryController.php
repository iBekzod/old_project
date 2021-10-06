<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Language;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = Country::paginate(15);
        return view('backend.setup_configurations.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // foreach (Language::all() as $language){
                    // Country Translations
                    $country_translations = CountryTranslation::firstOrNew(['lang' => $language->code, 'country_id' => $country->id]);
                    $country_translations->name = $country->name;
                    $country_translations->save();
                // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
       // if(CountryTranslations::where('country_id' , $country->id)->where('lang' , $request->lang)->first()){
            foreach (Language::all() as $language){
                $country_translations = BrandTranslation::firstOrNew(['lang' => $language->code, 'country_id' => $country->id]);
                $country_translations->name = $request->name;
                $country_translations->save();
            }
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateStatus(Request $request){
        $country = Country::findOrFail($request->id);
        $country->status = $request->status;
        if($country->save()){
            return 1;
        }
        return 0;
    }

}
