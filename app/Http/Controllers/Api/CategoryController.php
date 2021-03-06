<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Resources\CategoryCollection;
use App\BusinessSetting;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function all()
    {
        return response()->json([
            'categories' => Category::select('id', 'name', 'id', 'parent_id', 'slug', '_lft', '_rgt')->get()->toTree()
        ]);
    }

    public function index()
    {
        return new CategoryCollection(Category::where('level', 0)->get());
    }

    public function featured()
    {
        return new CategoryCollection(Category::where('featured', 1)->get());
    }

    public function home()
    {
        $homepageCategories = BusinessSetting::where('type', 'home_categories')->first();
        $homepageCategories = json_decode($homepageCategories->value);
        return new CategoryCollection(Category::whereIn('id', $homepageCategories)->get());
    }

    public function allCategories()
    {
        return response()->json([
            'categories' => Category::with('childrenCategories')->get()
        ]);
    }
}
