<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Controllers\SearchController;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategorySubCategoryCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\SearchProductCollection;
use App\Attribute;
use App\Category;
use App\Http\Resources\ProductColorCollection;
use App\Product;
use App\Seller;
use App\Utility\CategoryUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubCategoryController extends Controller
{
    public function index(Request $request, $id)
    {
        $category = Category::where('slug', $id)
            ->with(['products', 'childrenCategories', 'parentCategoryHierarchy'])
            ->firstOrFail();

        $category_collection = new CategoryCollection($category->childrenCategories);
        $category_collection->additional['filter'] = $this->searchByAttrs($request, $id);
        $category_collection->additional['category'] = Category::where('id', $id)->orWhere('slug', $id)->with('parent')->first();
        $category_collection->additional['category']['tag'] = $this->getTags($category->childrenCategories);
        $category_collection->additional['category']['brands'] = $this->getBrands($category->childrenCategories);
        $category_collection->additional['category']['min_price'] = getPublishedProducts('product')->get()->min('price');
        $category_collection->additional['category']['max_price'] = getPublishedProducts('product')->get()->max('price');
        $category_collection->additional['category']->banner = api_asset($category_collection->additional['category']->banner);
        $category_collection->additional['category']['breadcrumbs'] = $category->parentCategoryHierarchy;

        if($category->parentCategoryHierarchy) {
            function innerCategory($category, &$breadcrumbs)
            {
                $breadcrumbs[] = $category;
                if($category->parentCategoryHierarchy) {
                    innerCategory($category->parentCategoryHierarchy, $breadcrumbs);
                }
            }

            $breadcrumbs = [];
            $breadcrumbs[] = $category->parentCategoryHierarchy;
            if($category->parentCategoryHierarchy->parentCategoryHierarchy) {
                innerCategory($category->parentCategoryHierarchy->parentCategoryHierarchy, $breadcrumbs);
            }
            foreach ($breadcrumbs as $item) {
                unset($item->parentCategoryHierarchy);
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            $category_collection->additional['category']['breadcrumbs'] = $breadcrumbs;
        }

        return $category_collection;
    }

    public function subCategories($id)
    {

        $category = Category::where('slug',  $id )
            ->with('products')
            ->firstOrFail();

        $category_collection = new CategorySubCategoryCollection($category->categories);

        return $category_collection;
    }

    public function getTags($category)
    {
        $products = $category->map(function ($item) {
            return $item->products->all();
        });
        $array = [];
        foreach ($products as $value) {
            foreach ($value as $item) {
                $array[] = $item;
            }
        }
        $tags = [];
        foreach ($array as $item) {
            $data = explode(',', $item->tags);
            foreach ($data as $item2) {
                $tags[] = $item2;
            }
        }

        return $tags;
    }

    public function getBrands($category)
    {
        $products = $category->map(function ($item) {
            return $item->products->all();
        });

        $array = [];

        foreach ($products as $value) {
            foreach ($value as $item) {
                $array[] = $item;
            }
        }

        $brands = [];
          foreach ($array as $item) {
            if(!in_array($item->brand, $brands))
            {
                $data = $item->brand;
                $brands[] = $data;
            }
        }

        return $brands;
    }

    public function searchByAttrs($request, $id)
    {
        $category = \App\Category::where('id', $id)->orWhere('slug', $id)->first();

        if ($category != null) {
            $request->id = $category->slug;
            return $this->searchPr('category', $request);
        }

        abort(404);
    }

    public function searchPr($type, $request)
    {
        $product_conditions=[];
        $element_conditions=[];
        //Filtering by brand slug
        switch ($type) {
            case 'brand':
                if ($brand = Brand::where('slug', $request->id)->firstOrFail()) {
                    $element_conditions['where'][] = ['brand_id', $brand->id];
                }
                break;
            case 'flashdeals':
                if ($flash_deal = FlashDeal::where('slug', $request->id)->firstOrFail()) {
                    $product_ids = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->pluck('product_id');
                    $product_conditions['whereIn'][] = ['id' => $product_ids];
                }
                break;
            case 'category':
                if ($categoryA = Category::where('slug', $request->id)->firstOrFail()) {
                    $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
                    $element_conditions['whereIn'][] = ['category_id' => $category_ids];
                }
                break;
            case 'categoryAll':
                $category_ids = Category::where('level', '=', 2)->pluck('id');
                $element_conditions['whereIn'][] = ['category_id' => $category_ids];
                break;
            case 'categoryPopular':
                $category_ids = Category::where('featured', 1)->where('level', '=', 2)->pluck('id');
                $element_conditions['whereIn'][] = ['category_id' => $category_ids];
                break;
            case 'seller':
                if ($seller = Shop::select('user_id')->where('slug', $request->id)->firstOrFail()) {
                    $product_conditions['where'][] = ['user_id', $seller->user_id];
                }
                break;
            case 'new':
                $product_conditions['orderBy'][] = ['created_at' => 'desc'];
                if ($request->id!="list" && $categoryA = Category::where('slug', $request->id)->firstOrFail()) {
                    $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
                    $element_conditions['whereIn'][] = ['category_id' => $category_ids];
                }
                break;
            case 'todays_deal':
                $product_conditions['where'][] = ['todays_deal', 1];
                break;
            case 'popular':
                $product_conditions['where'][] = ['todays_deal', 1];
                if ($request->id!="list" && $categoryA = Category::where('slug', $request->id)->firstOrFail()) {
                    $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
                    $element_conditions['whereIn'][] = ['category_id' => $category_ids];
                }
                break;
            case 'recommendation':
                $product_conditions['where'][] = ['featured', 1];
                if ($request->id!="list" && $categoryA = Category::where('slug', $request->id)->firstOrFail()) {
                    $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
                    $element_conditions['whereIn'][] = ['category_id' => $category_ids];
                }
                break;
            case 'stock':
                $product_conditions['where'][] = ['discount', '>', 0];
                break;
            case 'freeDelevery':
                $product_conditions['where'][] = ['delivery_type', 'free'];
                break;
            case 'installment':
                $product_conditions['where'][] = ['delivery_type', 'free'];
                break;

            default:
                # code...
                break;
        }
        $products_count=getPublishedProducts('product', $product_conditions, [], $element_conditions)->count();
        $attribute_product_conditions = $product_conditions;
        $attribute_element_conditions = $element_conditions;
        //Order by sorting type
        $sort_by = $request->sort_by;
        if ($sort_by != null) {
            switch ($sort_by) {
                case 'newest':
                    $product_conditions['orderBy'][] = ['created_at' => 'desc'];
                    break;
                case 'oldest':
                    $product_conditions['orderBy'][] = ['created_at' => 'asc'];
                    break;
                case 'price-asc':
                    $product_conditions['orderBy'][] = ['price' => 'asc'];
                    break;
                case 'price-desc':
                    $product_conditions['orderBy'][] = ['price' => 'desc'];
                    break;
                default:
                    // code...
                    break;
            }
        }

        //Новинки
        if ($request->has('new') && $request->new) {
            $product_conditions['orderBy'][] = ['created_at' => 'desc'];
        }
        //Deal
        if ($request->has('todaysDeal') && $request->new) {
            $product_conditions['where'][] = ['todays_deal', 1];
        }
        //Популярные
        if ($request->has('popular') && $request->popular) {
            $product_conditions['where'][] = ['todays_deal', 1];
        }
        //Рекомендуемые
        if ($request->has('recommendation') && $request->recommendation) {
            $product_conditions['where'][] = ['featured', 1];
        }
        //Акции
        if ($request->has('stock') && $request->stock) {
            $product_conditions['where'][] = ['discount', '>', 0];
        }
        //Бесплатная доставка
        if ($request->has('freeDelevery') && $request->freeDelevery) {
            $product_conditions['where'][] = ['delivery_type', 'free'];
        }
        //Доступно в рассрочку
        if ($request->has('installment') && $request->installment) {
            $product_conditions['where'][] = ['delivery_type', 'free'];
        }

        if ($request->has('brand') && $request->brand) {
            if ($brand = Brand::where('slug', $request->brand)->firstOrFail()) {
                $element_conditions['where'][] = ['brand_id', $brand->id];
            }
        }

        if ($request->has('q') && $query = $request->q) {
            // $searchController = new SearchController;
            // $searchController->store($request);
            $product_conditions['where'][] = ['name', 'like', '%' . $query . '%'];
            $element_conditions['where'][] = ['tags', 'like', '%' . $query . '%'];
        }
        //Filtering Attributes
        $variations = Variation::where('deleted_at', '=', null);
        $color_id_list = array();
        $has_color = false;
        if ($request->has('color') && count($request->color) > 0) {
            $color_id_list = $request->color;
            $has_color = true;
        }
        $characteristic_id_list = array();
        $has_characteristic = false;
        $filtered_variation_id_list = array();
        if ($request->has('attribute') && count($request->attribute) > 0) {
            $characteristic_id_list = $request->attribute;
            $has_characteristic = true;
        }
        foreach ($variations->get() as $variation) {
            $is_valid = false;
            if ($has_characteristic) {
                if (is_array(explode(',', $variation->characteristics))) {
                    foreach (explode(',', $variation->characteristics) as $characteristic_id) {
                        if (in_array($characteristic_id, $characteristic_id_list)) {
                            if ($has_color) {
                                if (in_array($variation->color_id, $color_id_list)) {
                                    $is_valid = true;
                                }
                            } else {
                                $is_valid = true;
                            }
                        }
                    }
                }
            } else if ($has_color) {
                if (in_array($variation->color_id, $color_id_list)) {
                    $is_valid = true;
                }
            }
            if ($is_valid) {
                $filtered_variation_id_list[] = $variation->id;
            }
        }
        if (count($filtered_variation_id_list) > 0) {
            $filtered_variation_id_list = array_unique($filtered_variation_id_list);
            $product_conditions['whereIn'][] = ['variation_id' => $filtered_variation_id_list];
        }
        $products = getPublishedProducts('product', $product_conditions, [], $element_conditions);
        $attribute_products = getPublishedProducts('product', $attribute_product_conditions, [], $attribute_element_conditions);
        // $products = Product::where('element_id', '<>', null);
        // $attribute_products = Product::where('element_id', '<>', null);
        // $products = filterProductByRelation($products, 'product', $product_conditions);
        // $attribute_products = filterProductByRelation($attribute_products, 'product', $attribute_product_conditions);
        // if (is_array($element_conditions)) {
        //     $products = filterProductByRelation($products, 'element', $element_conditions);
        //     $attribute_products = filterProductByRelation($attribute_products, 'element', $attribute_element_conditions);
        // }

        //Attribute collection
        $all_attributes = array();
        $all_characteristics = array();
        foreach ($attribute_products->get() as $product) {
            if($product->variation)
            $all_characteristics = array_unique(array_merge($all_characteristics, explode(',', $product->variation->characteristics)));
        }
        foreach ($all_characteristics as $characteristic) {
            if($item = Characteristic::where('id',$characteristic)->first())
                $all_attributes[$item->attribute_id][] = $characteristic;
        }
        $all_attributes = getAttributeFormat($all_attributes);

        //Color Collection
        $all_colors = array();
        foreach ($attribute_products->get() as $product) {
            if (($product->variation)  && $product->variation->color_id != null) {
                $all_colors[] = $product->variation->color_id;
            }
        }
        $all_colors = array_unique($all_colors);

        //Category collection
        $all_categories = getProductCategories($attribute_products, 0)->get();


        // dd($all_categories);

        //Price collection
        // $min_price =($products->get()->count()>0)? homeDiscountedBasePrice($products->first()->id) : 0;
        // $max_price = ($products->get()->count()>0)? homeDiscountedBasePrice($products->first()->id) : 0;
        // dd($max_price);

        // dd("end");


        $product_ids = [];
        foreach ($products->get() as $product) {
            $unit_price = homeDiscountedBasePrice($product->id);
            if ($request->has('min_price') && $selected_min_price = $request->min_price) {
                if ($unit_price <= $selected_min_price) {
                    continue;
                }
            }
            if ($request->has('max_price') && $selected_max_price = $request->max_price) {
                if ($unit_price >= $selected_max_price) {
                    continue;
                }
            }
            $product_ids[] = $product->id;
        }
        $products = $products->whereIn('id', $product_ids);
        $products = $products->paginate(50);
        $prices = [];
        foreach ($products as $product) {
            $prices[] = homeDiscountedBasePrice($product->id);
        }

        $min_price = (count($prices) > 0) ? min($prices) : 0;
        $max_price = (count($prices) > 0) ? max($prices) : 0;

        return response()->json([
            'products' => new ProductCollection($products),
            'products_count'=>$products_count??count($products),
            'attributes' => $all_attributes,
            'colors' => new ProductColorCollection($all_colors),
            'categories' => new CategoryCollection($all_categories),
            'min_price' => $min_price ?? null,
            'max_price' => $max_price ?? null,
            'selected_min_price' => (isset($selected_min_price)) ? $selected_min_price : $min_price,
            'selected_max_price' => (isset($selected_max_price)) ? $selected_max_price : $max_price,
            'type' => $type ?? null
        ]);
    }
}
