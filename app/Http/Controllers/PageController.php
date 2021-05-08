<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\PageTranslation;
use App\Language;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types=$this->page_types();
        return view('backend.website_settings.pages.create', compact('types'));
    }

    public function page_types(){
        return [
            'footer_1'=>translate('footer_1'),
            'footer_2'=>translate('footer_2'),
            'footer_3'=>translate('footer_3'),
            'footer_4'=>translate('footer_4'),
            'custom_page'=>translate('custom_page'),
        ];

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Page;
        $page->title = $request->title;
        if (Page::where('slug', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug)))->first() == null) {
            // $page->slug             = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
            $page->slug = SlugService::createSlug(Page::class, 'slug', slugify($request->slug));
            $page->type             = $request->type??"custom_page";
            $page->content          = $request->get('content');
            $page->meta_title       = $request->meta_title;
            $page->meta_description = $request->meta_description;
            $page->keywords         = $request->keywords;
            $page->meta_image       = $request->meta_image;
            $page->save();

            // $page_translation           = PageTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'page_id' => $page->id]);
            // $page_translation->title    = $request->title;
            // $page_translation->content  = $request->get('content');
            // $page_translation->save();

            foreach (Language::all() as $language){
                // Page Translations
                $page_translations = PageTranslation::firstOrNew(['lang' => $language->code, 'page_id' => $page->id]);
                $page_translations->title = $page->title;
                $page_translations->content = $page->content;
                $page_translations->save();
            }

            flash(translate('New page has been created successfully'))->success();
            return redirect()->route('website.pages');
        }

        flash(translate('Slug has been used already'))->warning();
        return back();
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
   public function edit(Request $request, $id)
   {
        $lang = $request->lang;
        $page_name = $request->page;
        $page = Page::where('slug', $id)->first();
        $types=$this->page_types();
        if($page != null){
          if ($page_name == 'home') {
            return view('backend.website_settings.pages.home_page_edit', compact('page','lang', 'types'));
          }
          else{
            return view('backend.website_settings.pages.edit', compact('page','lang', 'types'));
          }
        }
        abort(404);
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
        $page = Page::findOrFail($id);
        if (Page::where('id','!=', $id)->where('slug', preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug)))->first() == null) {
            if($page->type == 'custom_page'){
              // $page->slug           = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
              if($page->slug!=$request->slug)
                $page->slug =SlugService::createSlug(Page::class, 'slug',  slugify($request->slug));
            }
            if($request->lang == default_language()){
              $page->title          = $request->title;
              $page->content        = $request->get('content');
            }
            $page->type             = $request->type??"custom_page";
            $page->meta_title       = $request->meta_title;
            $page->meta_description = $request->meta_description;
            $page->keywords         = $request->keywords;
            $page->meta_image       = $request->meta_image;
            $page->save();

            if(PageTranslation::where('page_id' , $page->id)->where('lang' , default_language())->first()){
                foreach (Language::all() as $language){
                    $page_translation = PageTranslation::firstOrNew(['lang' => $language->code, 'page_id' =>$page->id]);
                    $page_translation->title = $request->title;
                    $page_translation->content = $request->content;
                    $page_translation->save();
                }
            }

            flash(translate('Page has been updated successfully'))->success();
            return redirect()->route('website.pages');
        }

      flash(translate('Slug has been used already'))->warning();
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
        $page = Page::findOrFail($id);
        foreach ($page->page_translations as $key => $page_translation) {
            $page_translation->delete();
        }
        if(Page::destroy($id)){
            flash(translate('Page has been deleted successfully'))->success();
            return redirect()->back();
        }
        return back();
    }

    public function show_custom_page($slug){
        $page = Page::where('slug', $slug)->first();
        if($page != null){
            return view('frontend.custom_page', compact('page'));
        }
        abort(404);
    }
}
