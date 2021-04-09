<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\SearchController;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\FlashDealProductCollection;
use App\Http\Resources\FreeShippingProductsCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\SearchProductCollection;
use App\Http\Resources\FlashDealCollection;
use App\Http\Resources\FlashDealsCollection;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Product;
use App\Models\Shop;
use App\Models\Color;
use App\Seller;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use phpDocumentor\Reflection\Types\Integer;

class ProductController extends Controller
{
    public function cloneProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required'
        ]);

        $product = Product::findOrFail($request->get('product_id'));
    }

    public function getAllProducts(Request $request)
    {
        $query = $request->get('q');

        if ($query) {
            return [
                'products' => Product::where('name', 'like', '%' . $query . '%')->get()
            ];
        } else {
            return [
            ];
        }
    }

    public function index()
    {
        return new ProductCollection(Product::inRandomOrder()->paginate(10));
    }

    public function show($id)
    {
        function innerCategory($category, &$breadcrumbs)
        {
            $breadcrumbs[] = $category;
            if ($category->parentCategoryHierarchy) {
                innerCategory($category->parentCategoryHierarchy, $breadcrumbs);
            }
        }

        $products = Product::where('id', $id)->orWhere('slug', $id)->get();
        $product = isset($products[0]) ? $products[0] : null;
        $breadcrumbs = [];
        if ($product) {
            $categories = $product->parentHierarchy;
            $breadcrumbs[] = $categories;
            if ($categories->parentCategoryHierarchy) {
                innerCategory($categories->parentCategoryHierarchy, $breadcrumbs);
            }
            foreach ($breadcrumbs as $item) {
                unset($item->parentCategoryHierarchy);
            }
            $breadcrumbs = array_reverse($breadcrumbs);
        }
        $product->breadcrumbs = $breadcrumbs;

        return [
            'product' => new ProductDetailCollection($products),
            'breadcrumbs' => $breadcrumbs
        ];
    }

    public function admin()
    {
        return new ProductCollection(Product::where('added_by', 'admin')->inRandomOrder()->paginate(10));
    }

    public function seller()
    {
        return new ProductCollection(Product::where('added_by', 'seller')->inRandomOrder()->paginate(10));
    }

    public function category(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        $categoryA = Category::where('slug', $id)->firstOrFail();
//        $category_ids = CategoryUtility::children_ids($id);
//        $category_ids[] = $id;
        $sort_by = $request->sort_by;

        $conditions = ['published' => 1];

//        if ($request->brand != null) {
//            $brand_id = (\App\Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
//            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
//        }

        $products = \App\Product::where($conditions);

        $category_ids = CategoryUtility::children_ids($categoryA->id);
        $category_ids[] = $id;

        $products = $products->whereIn('category_id', $category_ids);

        if ($sort_by != null) {
            switch ($sort_by) {
                case 'newest':
                    $products->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $products->orderBy('created_at', 'asc');
                    break;
                case 'price-asc':
                    $products->orderBy('unit_price', 'asc');
                    break;
                case 'price-desc':
                    $products->orderBy('unit_price', 'desc');
                    break;
                default:
                    // code...
                    break;
            }
        }


        $non_paginate_products = filter_products($products)->get();

        $attributes = array();

        foreach ($non_paginate_products as $key => $product) {
            if ($product->attributes != null && is_array(json_decode($product->attributes))) {
                foreach (json_decode($product->attributes) as $key => $value) {
                    $flag = false;
                    $pos = 0;
                    foreach ($attributes as $key => $attribute) {
                        if ($attribute['id'] == $value) {
                            $flag = true;
                            $pos = $key;
                            break;
                        }
                    }
                    if (!$flag) {
                        $item['id'] = $value;
                        $item['values'] = array();
                        foreach (json_decode($product->choice_options) as $key => $choice_option) {
                            if ($choice_option->attribute_id == $value) {
                                $item['values'] = $choice_option->values;
                                break;
                            }
                        }
                        array_push($attributes, $item);
                    } else {
                        foreach (json_decode($product->choice_options) as $key => $choice_option) {
                            if ($choice_option->attribute_id == $value) {
                                foreach ($choice_option->values as $key => $value) {
                                    if (!in_array($value, $attributes[$pos]['values'])) {
                                        array_push($attributes[$pos]['values'], $value);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        foreach ($attributes as $key => $attribute) {
            $attributes[$key]['attr'] = Attribute::find($attribute['id']);
        }

        $selected_attributes = array();

        foreach ($attributes as $key => $attribute) {
            if ($request->has('attribute_' . $attribute['id'])) {
                foreach ($request['attribute_' . $attribute['id']] as $key => $value) {
                    $str = '"' . $value . '"';
                    $products = $products->where('choice_options', 'like', '%' . $str . '%');
                }

                $item['id'] = $attribute['id'];
                $item['values'] = $request['attribute_' . $attribute['id']];
                array_push($selected_attributes, $item);
            }
        }


        return new ProductCollection(
            Product::whereIn('category_id', $category_ids)
                ->inRandomOrder()
                ->paginate(10)
        );
    }

    public function subCategory($id)
    {
        $category_ids = CategoryUtility::children_ids($id);
        $category_ids[] = $id;

        return new ProductCollection(Product::whereIn('category_id', $category_ids)->where('is_accepted', 1)->inRandomOrder()->paginate(10));
    }

    public function subSubCategory($id)
    {
        $category_ids = CategoryUtility::children_ids($id);
        $category_ids[] = $id;

        return new ProductCollection(Product::whereIn('category_id', $category_ids)->where('is_accepted', 1)->inRandomOrder()->paginate(10));
    }

    public function brand($id)
    {
        return new ProductCollection(Product::where('brand_id', $id)->where('is_accepted', 1)->inRandomOrder()->paginate(10));
    }

    public function todaysDeal()
    {
        return new ProductCollection(Product::where('todays_deal', 1)->where('is_accepted', 1)->latest()->get());
    }

    public function flashDeal()
    {
        $flash_deals = FlashDeal::where('status', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
        return new FlashDealsCollection($flash_deals);
    }

    public function singleFlashDeal($id)
    {
        $flash_deals = FlashDeal::where('slug', $id)->firstOrFail();
        return new FlashDealCollection($flash_deals);
    }

    public function featured()
    {
        return new ProductCollection(Product::where('featured', 1)->where('is_accepted', 1)->inRandomOrder()->get());
    }

    public function featuredFlashDeals()
    {
        $flash_deals = FlashDeal::where('featured', 1)->where('status', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
        return new FlashDealsCollection($flash_deals);

        // $flash_deals = FlashDeal::where('featured', 1)->where('status', 1)->get();
        // $products = collect();
        // foreach ($flash_deals as $flash_deal) {
        //     foreach ($flash_deal->flashDealProducts as $key => $flash_deal_product) {
        //         if(Product::find($flash_deal_product->product_id) != null){
        //                 $products->push(Product::find($flash_deal_product->product_id));
        //         }
        //     }
        // }
        // return [
        //     'products' => new ProductCollection($products)
        // ];
    }

    public function singleFeaturedFlashDeal($id)
    {
        $flash_deals = FlashDeal::where('featured', 1)->where('status', 1)->where('slug', $id)->firstOrFail();
        return new FlashDealCollection($flash_deals);
    }

    public function bestSeller()
    {
        return new ProductCollection(Product::orderBy('num_of_sale', 'desc')->where('is_accepted', 1)->limit(20)->get());
    }

    public function related($id)
    {
        $product = Product::find($id);
        if ($product)
            return new ProductCollection(Product::where('category_id', $product->category_id)->where('is_accepted', 1)->where('id', '!=', $id)->inRandomOrder()->limit(10)->get());

        return response()->json([
            'error' => 'Такого продукта не существует.'
        ], 404);
    }

    public function topFromSeller($id)
    {
        $product = Product::find($id);
        return new ProductCollection(Product::where('user_id', $product->user_id)->where('is_accepted', 1)->orderBy('num_of_sale', 'desc')->limit(4)->get());
    }

    public function search()
    {
        $key = request('key');
        $scope = request('scope');

        switch ($scope) {

            case 'price_low_to_high':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('unit_price', 'asc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            case 'price_high_to_low':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('unit_price', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            case 'new_arrival':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('created_at', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            case 'popularity':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('num_of_sale', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            case 'top_rated':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('rating', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            // case 'category':
            //
            //     $categories = Category::select('id')->where('name', 'like', "%{$key}%")->get()->toArray();
            //     $collection = new SearchProductCollection(Product::where('category_id', $categories)->orderBy('num_of_sale', 'desc')->paginate(10));
            //     $collection->appends(['key' =>  $key, 'scope' => $scope]);
            //     return $collection;
            //
            // case 'brand':
            //
            //     $brands = Brand::select('id')->where('name', 'like', "%{$key}%")->get()->toArray();
            //     $collection = new SearchProductCollection(Product::where('brand_id', $brands)->orderBy('num_of_sale', 'desc')->paginate(10));
            //     $collection->appends(['key' =>  $key, 'scope' => $scope]);
            //     return $collection;
            //
            // case 'shop':
            //
            //     $shops = Shop::select('user_id')->where('name', 'like', "%{$key}%")->get()->toArray();
            //     $collection = new SearchProductCollection(Product::where('user_id', $shops)->orderBy('num_of_sale', 'desc')->paginate(10));
            //     $collection->appends(['key' =>  $key, 'scope' => $scope]);
            //     return $collection;

            default:
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orWhere('tags', 'like', "%{$key}%")->orderBy('num_of_sale', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;
        }
    }

    public function variantPrice(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $str = '';
        $tax = 0;

        if ($request->has('color')) {
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode($request->choice) as $option) {
            $str .= $str != '' ? '-' . str_replace(' ', '', $option->name) : str_replace(' ', '', $option->name);
        }

        if ($str != null && $product->variant_product) {
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;
            $stockQuantity = $product_stock->qty;
        } else {
            $price = $product->unit_price;
            $stockQuantity = $product->current_stock;
        }

        //discount calculation
        $flash_deals = FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $key => $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $price -= ($price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }
        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }

        return response()->json([
            'product_id' => $product->id,
            'variant' => $str,
            'price' => (double)$price,
            'in_stock' => $stockQuantity < 1 ? false : true
        ]);
    }

    public function home()
    {
        return new ProductCollection(Product::inRandomOrder()->take(50)->get());
    }

    public function freeShippingProduct()
    {
        return response()->json([
            'products' => new ProductCollection(\App\Models\Product::where('shipping_type', 'free')->inRandomOrder()->limit(12)->get())
        ]);
    }

    public function byBrand($name)
    {
        $brand = Brand::select('*')->where('name', $name)->get();
        $products = Product::select('*')->where('brand_id', $brand[0]['id'])->orderBy('num_of_sale', 'desc')->limit(12)->get();
        $minPrice = Product::select('unit_price')->where('unit_price', '>=', 0)->where('brand_id',$brand[0]['id'])->min('unit_price');
        $maxPrice = Product::select('unit_price')->where('unit_price', '>=', 0)->where('brand_id',$brand[0]['id'])->max('unit_price');

        return json_encode(array(
            'id' => $brand[0]['id'],
            'name' => $brand[0]['name'],
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'products' => new ProductCollection($products)
        ));
    }

    public function getAllBySlug($type,$id,Request $request){
        $response = "";
        switch ($type){
            case "category" :
                $r = Category::select('id')->where('slug',$id)->get();
                $response = $this->searchPr($type,$r[0]['id'],$request);
                break;
            case "brand" :
                $r = Brand::select('id')->where('name',$id)->get();
                $response = $this->searchPr($type,$r[0]['id'],$request);
                break;
            case "seller" :
                $r = Shop::select('user_id')->where('slug',$id)->get();
                $response = $this->searchPr($type,$r[0]['user_id'],$request);
                break;
        }

        return $response;
    }

    public function searchPr($type,$id,$request)
    {
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        $conditions = [];

        switch ($type){
            case "seller" :
                $conditions = ['published' => 1,'user_id' => $id];
                break;
            case "brand" :
                $conditions = ['published' => 1,'brand_id' => $id];
                break;
            case "category" :
                $conditions = ['published' => 1,'category_id' => $id];
                break;
            default :

                break;
        }



        $products = Product::where($conditions);

        if ($products != null){
            if($min_price != null && $max_price != null){
                $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
            }

            if($sort_by != null){
                switch ($sort_by) {
                    case 'newest':
                        $products->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $products->orderBy('created_at', 'asc');
                        break;
                    case 'price-asc':
                        $products->orderBy('unit_price', 'asc');
                        break;
                    case 'price-desc':
                        $products->orderBy('unit_price', 'desc');
                        break;
                    default:
                        // code...
                        break;
                }
            }


            $non_paginate_products = filter_products($products)->get();

            //Attribute Filter

            $attributes = array();
            foreach ($non_paginate_products as $key => $product) {
                if($product->attributes != null && is_array(json_decode($product->attributes))){
                    foreach (json_decode($product->attributes) as $key => $value) {
                        $flag = false;
                        $pos = 0;
                        foreach ($attributes as $key => $attribute) {
                            if($attribute['id'] == $value){
                                $flag = true;
                                $pos = $key;
                                break;
                            }
                        }
                        if(!$flag){
                            $item['id'] = $value;
                            $item['values'] = array();
                            foreach (json_decode($product->choice_options) as $key => $choice_option) {
                                if($choice_option->attribute_id == $value){
                                    $item['values'] = $choice_option->values;
                                    break;
                                }
                            }
                            array_push($attributes, $item);
                        }
                        else {
                            foreach (json_decode($product->choice_options) as $key => $choice_option) {
                                if($choice_option->attribute_id == $value){
                                    foreach ($choice_option->values as $key => $value) {
                                        if(!in_array($value, $attributes[$pos]['values'])){
                                            array_push($attributes[$pos]['values'], $value);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $selected_attributes = array();
            foreach ($attributes as $key => $attribute) {
                $attr = Attribute::find($attribute['id']);
                if ($attr != null)
                {
                    $attributes[$key]['attr'] = $attr;
                }else{
                    unset($attributes[$key]);
                }
            }



            //Color Filter
            $all_colors = array();

            foreach ($non_paginate_products as $key => $product) {
                if ($product->colors != null) {
                    foreach (json_decode($product->colors) as $key => $color) {
                        if(!in_array($color, $all_colors)){
                            array_push($all_colors, $color);
                        }
                    }
                }
            }


            $products = filter_products($products)->paginate(12)->appends(request()->query());
            return json_encode(array(
                'products' => new ProductCollection($products),
                'attributes' => $attributes,
                'type' => $type
            ));
        }else {
            return json_encode(array(
                'products' => [],
                'attributes' => [],
                'type' => $type
            ));
        }


    }
}
