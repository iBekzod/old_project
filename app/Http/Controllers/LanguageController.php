<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use File;
use App\Language;
use App\Translation;
use App\ProductTranslation as productTranslation;
use App\CategoryTranslation as categoryTranslation;
use DB;
use View;

class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $request->session()->put('locale', $request->locale);
        $language = Language::where('code', $request->locale)->first();
        flash(translate('Language changed to ') . $language->name)->success();
    }

    public function index(Request $request)
    {
        $languages = Language::paginate(10);
        return view('backend.setup_configurations.languages.index', compact('languages'));
    }

    public function create(Request $request)
    {
        return view('backend.setup_configurations.languages.create');
    }

    public function store(Request $request)
    {
        $language = new Language;
        $language->name = $request->name;
        $language->code = $request->code;
        if ($language->save()) {

            flash(translate('Language has been inserted successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function show(Request $request, $id)
    {
        $sort_search = null;
        $language = Language::findOrFail(decrypt($id));
        $lang_keys = Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'));
        if ($request->has('search')) {
            $sort_search = $request->search;
            $lang_keys = $lang_keys->where('lang_key', 'like', '%' . $sort_search . '%');
        }
        $lang_keys = $lang_keys->latest()->paginate(50);
        return view('backend.setup_configurations.languages.language_view', compact('language', 'lang_keys', 'sort_search'));
    }

    public function edit($id)
    {
        $language = Language::findOrFail(decrypt($id));
        return view('backend.setup_configurations.languages.edit', compact('language'));
    }

    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->code = $request->code;
        if ($language->save()) {
            flash(translate('Language has been updated successfully'))->success();
            return redirect()->route('languages.index');
        } else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function key_value_store(Request $request)
    {
        $language = Language::findOrFail($request->id);
        foreach ($request->values as $key => $value) {
            $translation_def = Translation::where('lang_key', $key)->where('lang', $language->code)->first();
            if ($translation_def == null) {
                $translation_def = new Translation;
                $translation_def->lang = $language->code;
                $translation_def->lang_key = $key;
                $translation_def->lang_value = $value;
                $translation_def->save();
            } else {
                $translation_def->lang_value = $value;
                $translation_def->save();
            }
        }
        flash(translate('Translations updated for ') . $language->name)->success();
        return back();
    }

    public function update_rtl_status(Request $request)
    {
        $language = Language::findOrFail($request->id);
        $language->rtl = $request->status;
        if ($language->save()) {
            flash(translate('RTL status updated successfully'))->success();
            return 1;
        }
        return 0;
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        if (env('DEFAULT_LANGUAGE') == $language->code) {
            flash(translate('Default language can not be deleted'))->error();
        } else {
            Language::destroy($id);
            flash(translate('Language has been deleted successfully'))->success();
        }
        return redirect()->route('languages.index');
    }

    public function show_translation(Request $request)
    {
        try {
            $sort_search = null;
            $col_arr=$request->columns_arr;
            ($request->has('fields'))? $fields = $request->fields : $fields=['name'];
            ($request->has('selected_field'))? $selected_field = $request->selected_field : $selected_field=0;
            ($request->has('base_table'))? $base_table = $request->base_table : $base_table='products';
            ($request->has('table_translations'))? $table_translations = $request->table_translations : $table_translations='product_translations';
            ($request->has('relation_id'))? $relation_id = $request->relation_id : $relation_id='product_id';
            ($request->has('language_selected'))? $language_selected = $request->language_selected : $language_selected=env('DEFAULT_LANGUAGE', 'en');
            $my_column=$fields[$selected_field];
            $translations=DB::table($base_table)
            ->join($table_translations, $base_table.'.id', '=', $table_translations.'.'.$relation_id)
            ->select([$base_table.'.id as id', $base_table.'.'.$my_column.' as key', $table_translations.'.'.$my_column.' as value', $table_translations.'.lang as lang', $base_table.'.created_at' ]);
            if($language_selected!='all'){
                $translations = $translations->where('lang', $language_selected);
            }
            $translations = $translations->orderBy('created_at', 'desc');
            // $languages = Language::select(['name', 'code'])->get();
            if ($request->has('search')) {
                $sort_search = $request->search;
                $translations = $translations->where('key', 'like', '%' . $sort_search . '%')->orWhere('value', 'like', '%' . $sort_search . '%');
            }
            $translations = $translations->paginate(50);
            return view('backend.translations.translations',
            compact(
                'sort_search', 'language_selected', 'translations',
                'base_table','table_translations', 'relation_id', 'fields', 'selected_field'
                ));
        } catch (\Exception $e) {
            return back();
        }
    }
    // public function select_translation_language(Request $request){
    //     try {
    //         $sort_search = null;
    //         ($request->has('base_table'))? $base_table = $request->base_table : $base_table='products';
    //         ($request->has('table_translations'))? $table_translations = $request->table_translations : $table_translations='product_translations';
    //         ($request->has('relation_id'))? $relation_id = $request->relation_id : $relation_id='product_id';
    //         ($request->has('language_selected'))? $language_selected = $request->language_selected : $language_selected=env('DEFAULT_LANGUAGE', 'en');

    //         $translations=DB::table($base_table)
    //         ->join($table_translations, $base_table.'.id', '=', $table_translations.'.'.$relation_id)
    //         ->select([$base_table.'.id as id', $base_table.'.name as key', $table_translations.'.name as value', $table_translations.'.lang as lang', $base_table.'.created_at' ]);
    //         if($language_selected!='all'){
    //             $translations = $translations->where('lang', $language_selected);
    //         }
    //         $translations = $translations->orderBy('created_at', 'desc');
    //         // $languages = Language::select(['name', 'code'])->get();
    //         if ($request->has('search')) {
    //             $sort_search = $request->search;
    //             $translations = $translations->where('key', 'like', '%' . $sort_search . '%')->orWhere('value', 'like', '%' . $sort_search . '%');
    //         }
    //         $translations = $translations->paginate(50);
    //         return View::make('backend.translations.translations',
    //         compact(
    //             'sort_search', 'language_selected', 'translations',
    //             'base_table','table_translations', 'relation_id'
    //             ));
    //     } catch (\Exception $e) {
    //         dd($e->getMessage());
    //         return back();
    //     }
    // }
    public function key_value_store_translations(Request $request)
    {
        try {
            ($request->has('fields'))? $fields = $request->fields : $fields=['name'];
            ($request->has('selected_field'))? $selected_field = $request->selected_field : $selected_field=0;
            ($request->has('base_table'))? $base_table = $request->base_table : $base_table='products';
            ($request->has('table_translations'))? $table_translations = $request->table_translations : $table_translations='product_translations';
            ($request->has('relation_id'))? $relation_id = $request->relation_id : $relation_id='product_id';
            ($request->has('language_selected'))? $language_selected = $request->language_selected : $language_selected=env('DEFAULT_LANGUAGE', 'en');
            $my_column=$fields[$selected_field];
             $language = Language::where('code', $language_selected)->first();
            foreach ($request->values as $key => $value) {
                if($language_selected!='all'){
                    $result = DB::table($table_translations)->updateOrInsert(
                        [$relation_id=>$key,'lang'=>$language_selected],
                        [$my_column=>$value]);
                }else{
                    $result = DB::table($table_translations)->updateOrInsert(
                        [$relation_id=>$key],
                        [$my_column=>$value]);
                }
            }
            flash(translate('Translations updated for ') . $language->name)->success();
            return back();
        } catch (\Exception $e) {
            return back();
        }
    }
}
