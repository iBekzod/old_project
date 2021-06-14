<?php

namespace App\Http\Controllers;

use App\Attribute;
use Illuminate\Http\Request;
use App\Category;
use App\HomeCategory;
use App\Product;
use App\Language;
use App\CategoryTranslation;
use App\Utility\CategoryUtility;
use Illuminate\Support\Str;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $categories = Category::orderBy('name', 'asc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $categories = $categories->where('name', 'like', '%'.$sort_search.'%');
        }
        $categories = $categories->paginate(15);
        return view('backend.product.categories.index', compact('categories', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all()->toTree();

    return view('backend.product.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->digital = $request->digital;
        $category->banner = $request->banner;
        $category->icon = $request->icon;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;

        if($request->has('attribute_ids')){
            $attribute_ids=$request->attribute_ids;
//            $attributes=Attribute::whereIn('id', $attribute_ids);
//            $category->attributes()->detach();
            $category->attributes()->attach($attribute_ids);
            if($category->level==0 || $category->level==1){
                foreach ($category->childrenCategories as $children){
                    $children->attributes()->attach($attribute_ids);
                    if($children->level==1) {
                        foreach ($children->childrenCategories as $child) {
                            $child->attributes()->attach($attribute_ids);
                        }
                    }
                }
            }

        }
        if ($request->parent_id != "0") {
            $category->parent_id = $request->parent_id;

            $parent = Category::find($request->parent_id);
            $category->level = $parent->level + 1 ;
        }

        if ($request->slug != null) {
            // $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));

            $category->slug = SlugService::createSlug(Category::class, 'slug', slugify($request->slug));
        }
        else {
            // $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);

            $category->slug = SlugService::createSlug(Category::class, 'slug', slugify($request->name));
        }
        if ($request->commision_rate != null) {
            $category->commision_rate = $request->commision_rate;
        }

        $category->save();

        foreach (Language::all() as $language){
            // Category Translations
            $category_translation = CategoryTranslation::firstOrNew(['lang' => $language->code, 'category_id' => $category->id]);
            $category_translation->name = $category->name;
            $category_translation->save();
        }

        flash(translate('Category has been inserted successfully'))->success();
        return redirect()->route('categories.index');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $mainCategory = Category::findOrFail($id);
        $category_attribute_ids=$mainCategory->attributes->pluck('id')->toArray();
        $categories = Category::all()->toTree();

        return view('backend.product.categories.edit', compact('mainCategory', 'categories', 'lang', 'category_attribute_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        if($request->lang ==default_language()){
            $category->name = $request->name;
        }
        $category->digital = $request->digital;
        $category->banner = $request->banner;
        $category->icon = $request->icon;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;

        $previous_level = $category->level;

        if($request->has('attribute_ids')){
            $attribute_ids=$request->attribute_ids;
//            $attributes=Attribute::whereIn('id', $attribute_ids);
            $category->attributes()->detach();
            $category->attributes()->attach($attribute_ids);
            if($category->level==0 || $category->level==1){
                foreach ($category->childrenCategories as $children){
                    $children->attributes()->detach();
                    $children->attributes()->attach($attribute_ids);
                    if($children->level==1) {
                        foreach ($children->childrenCategories as $child) {
                            $child->attributes()->detach();
                            $child->attributes()->attach($attribute_ids);
                        }
                    }
                }
            }
        }

        if ($request->parent_id != "0") {
            $category->parent_id = $request->parent_id;

            $parent = Category::find($request->parent_id);
            $category->level = $parent->level + 1 ;
        }
        else{
            $category->parent_id = 0;
            $category->level = 0;
        }

        if($category->level > $previous_level){
            CategoryUtility::move_level_down($category->id);
        }
        elseif ($category->level < $previous_level) {
            CategoryUtility::move_level_up($category->id);
        }

        if ($request->slug != null) {
            // $category->slug = strtolower($request->slug);
            if($category->slug!=$request->slug){
                $category->slug = SlugService::createSlug(Category::class, 'slug', slugify($request->slug));
            }
        }
        else {
            // $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.Str::random(5);
            $category->slug = SlugService::createSlug(Category::class, 'slug', slugify($request->name));
        }


        if ($request->commision_rate != null) {
            $category->commision_rate = $request->commision_rate;
        }

        $category->save();

        if(CategoryTranslation::where('category_id' , $category->id)->where('lang' ,default_language())->first()){
            foreach (Language::all() as $language){
                $cotegory_translation = CategoryTranslation::firstOrNew(['lang' => $language->code, 'category_id' => $category->id]);
                $cotegory_translation->name = $request->name;
                $cotegory_translation->save();
            }
        }

        flash(translate('Category has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // $category = Category::findOrFail($id);

        // // Category Translations Delete
        // foreach ($category->category_translations as $key => $category_translation) {
        //     $category_translation->delete();
        // }

        // foreach (Product::where('category_id', $category->id)->get() as $product) {
        //     $product->category_id = null;
        //     $product->save();
        // }

        CategoryUtility::delete_category($id);

        flash(translate('Category has been deleted successfully'))->success();
        return redirect()->route('categories.index');
    }

    public function updateFeatured(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->featured = $request->status;
        if($category->save()){
            return 1;
        }
        return 0;
    }
}
