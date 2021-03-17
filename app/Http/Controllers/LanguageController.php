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
            $translations = [];
            if ($request->has('database')) {
                $database = $request->database;
            } else {
                $database = 'product_translations';
            }
            $translations = DB::table($database)->select(['id', 'name', 'lang', 'created_at']);
            $languages = Language::select(['name', 'code'])->get();
            $language_selected = 'en';
            if ($request->has('language_selected')) {
                $language_selected = $request->language_selected;
            } else {
                $language_selected = env('DEFAULT_LANGUAGE', 'en');
            }
            $translations = $translations->where('lang', $language_selected);
            if ($request->has('search')) {
                $translations = $translations->where('name', 'like', '%' . $request->search . '%');
            }
            //dd($translations);
            $translations = $translations->paginate(50);
            // dd($languages);
            return view('backend.translations.product_translations', ['language_selected' => $language_selected, 'translations' => $translations, compact('languages', 'sort_search')]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            // return back();
        }
    }

    public function show_product_translations(Request $request)
    {
        try {



            $myClass = ProductTranslation::class;
            $relation = 'product';


            $sort_search = null;
            $translations = $myClass::with($relation)->select(['id', 'name', 'lang', 'created_at']);

            $translations = $myClass::with($relation)->get();
            $translations = ProductTranslation::with('product')->get();

           // $translations->getakk();




         //   echo "<pre>";
            dd( $translations);



            return view('backend.translations.product_translations', [
                'language_selected' => $language_selected,
                'translations' => $translations,
                'relation' => $relation,
               compact('languages', 'sort_search')
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
            // return back();
        }
    }

    public function show_category_translations(Request $request)
    {
        try {
            $sort_search = null;
            $translations = CategoryTranslation::with('category'); //->select(['id', 'name', 'lang', 'created_at']);
            $languages = Language::select(['name', 'code'])->get();
            $language_selected = 'en';
            if ($request->has('language_selected')) {
                $language_selected = $request->language_selected;
            } else {
                $language_selected = env('DEFAULT_LANGUAGE', 'en');
            }
            $translations = $translations->where('lang', $language_selected);
            if ($request->has('search')) {
                $translations = $translations->where('name', 'like', '%' . $request->search . '%');
            }
            $translations = $translations->latest()->paginate(50);
            return view('backend.setup_configurations.translations.language_view', ['language_selected' => $language_selected, 'translations' => $translations, compact('languages', 'sort_search')]);
        } catch (\Exception $e) {
            return back();
        }
    }

    public function key_value_store_product_translations(Request $request)
    {
        $language = Language::findOrFail($request->id);
        foreach ($request->values as $key => $value) {
            $translation_def = ProductTranslation::where('name', $key)->where('lang', $language->code)->first();
            if ($translation_def == null) {
                $translation_def = new ProductTranslation;
                $translation_def->lang = $language->code;
                $translation_def->name = $value;
                // $translation_def->lang_key = $key;
                // $translation_def->lang_value = $value;
                $translation_def->save();
            } else {
                $translation_def->lang_value = $value;
                $translation_def->save();
            }
        }
        flash(translate('Translations updated for ') . $language->name)->success();
        return back();
    }
}
