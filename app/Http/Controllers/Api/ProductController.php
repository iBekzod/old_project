<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\SearchController;
// use App\Http\Resources\CategoryCollection;
// use App\Http\Resources\FlashDealProductCollection;
// use App\Http\Resources\FreeShippingProductsCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\SearchProductCollection;
use App\Http\Resources\FlashDealCollection;
use App\Http\Resources\FlashDealsCollection;
use App\Attribute;
use App\Brand;
use App\Category;
use App\FlashDeal;
use App\FlashDealProduct;
use App\Product;
use App\Shop;
use App\Color;
use App\Element;
use App\Http\Resources\ElementCollection;
use App\Http\Resources\VariationCollection;
// use App\Seller;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use App\Variation;

// use Illuminate\Http\Resources\Json\ResourceCollection;
// use phpDocumentor\Reflection\Types\Integer;

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
        $product=null;
        $product_collection=null;
        $breadcrumbs[] = null;
        if($product=Product::where('slug', $id)->first()){
            $variation=$product->variation;
            $element=Element::findOrFail($variation->element_id);
            $categories = $element->parentHierarchy;
            $breadcrumbs[] = $categories;
            if ($categories->parentCategoryHierarchy) {
                innerCategory($categories->parentCategoryHierarchy, $breadcrumbs);
            }
            foreach ($breadcrumbs as $item) {
                unset($item->parentCategoryHierarchy);
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            // $product->breadcrumbs = $breadcrumbs;
            $product_collection=new ProductDetailCollection($product);
        }
        // dd($product);
        return [
            'product' => $product_collection,
            'breadcrumbs' => $breadcrumbs
        ];
    }

    public function admin()
    {
        if($variations= Variation::where('lowest_price_id','<>', null)->inRandomOrder()->groupBy('element_id')->get()){
            return new VariationCollection($variations);
        }
        // return null;
        // return Product::where('added_by', 'admin')->inRandomOrder()->paginate(10);

    }

    public function seller()
    {
        return $this->admin();
        // if($variations = Variation::where('lowest_price_id','<>', null)->get()){
        //     // dd($variations);
        //     return new ProductCollection($variations);
        // }
        // return null;
        // return new ProductCollection(Product::where('added_by', 'seller')->inRandomOrder()->paginate(10));
    }

    public function category(Request $request, $id)
    {
        if (!$id) {
            abort(404);
        }
        $categoryA = Category::where('slug', $id)->firstOrFail();
        $ids = Category::descendantsAndSelf($categoryA->id)->where('level','=', 2)->map(function ($category) {
            return $category->id;
        });
        $conditions = ['published' => 1, 'featured'=>1];
        $products = Product::where($conditions)->whereIn('subsubcategory_id',$ids);
//        $category_ids = CategoryUtility::children_ids($id);
//        $category_ids[] = $id;
        $sort_by = $request->sort_by;

//        $conditions = ['published' => 1];

//        if ($request->brand != null) {
//            $brand_id = (\App\Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
//            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
//        }

//        $products = \App\Product::where($conditions);

//        $category_ids = CategoryUtility::children_ids($categoryA->id);
//        $category_ids[] = $id;
//
//        $products = $products->whereIn('category_id', $category_ids);

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


        return new ProductCollection($products->inRandomOrder()->paginate(10));
    }

    public function featuredCategoryProducts($slug){
        return $this->admin();
//        if (!$id) {
//            abort(404);
//        }
        $categoryA = Category::where('slug', $slug)->firstOrFail();
        $ids = Category::descendantsAndSelf($categoryA->id)->where('level','=', 2)->map(function ($category) {
            return $category->id;
        });
        $conditions = ['published' => 1, 'featured'=>1];
        $products = Product::where($conditions)->whereIn('subsubcategory_id',$ids);
        return new ProductCollection($products->inRandomOrder()->paginate(12));
    }

    public function subCategory($id)
    {
        return $this->admin();
        $category_ids = CategoryUtility::children_ids($id);
        $category_ids[] = $id;

        return new ProductCollection(Product::whereIn('category_id', $category_ids)->where('is_accepted', 1)->inRandomOrder()->paginate(10));
    }

    public function subSubCategory($id)
    {
        return $this->admin();
        $category_ids = CategoryUtility::children_ids($id);
        $category_ids[] = $id;

        return new ProductCollection(Product::whereIn('category_id', $category_ids)->where('is_accepted', 1)->inRandomOrder()->paginate(10));
    }

    public function brand($id)
    {
        return $this->admin();

        $products=Product::where('brand_id', $id)->where('is_accepted', 1)->inRandomOrder()->paginate(10);
        return new ProductCollection($products);
    }

    public function todaysDeal()
    {
        return $this->admin();
        return new ProductCollection(Product::where('todays_deal', 1)->where('is_accepted', 1)->latest()->get());
    }

    public function flashDeal()
    {
        return $this->admin();
        $flash_deals = FlashDeal::where('status', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
        return new FlashDealsCollection($flash_deals);
    }

    public function singleFlashDeal($id)
    {
        return $this->admin();
        $flash_deal = FlashDeal::where('slug', $id)->firstOrFail();
        $ids = FlashDealProduct::where('flash_deal_id',$flash_deal->id)->pluck('product_id');
        $products = Product::whereIn('id',$ids)->get();
        $min_price = ($products)->min('unit_price');
        $max_price = ($products)->max('unit_price');
        return [
            'title' => $flash_deal->title,
            'end_date' => $flash_deal->end_date,
            'products' => new ProductCollection($products),
            'min_price'=>$min_price,
            'max_price'=>$max_price,
            'slug'=>$flash_deal->slug,
        ];
//        return new FlashDealCollection($flash_deals);
    }

    public function featured()
    {
        return $this->admin();
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
        return $this->admin();
        // return $this->admin();
        $products=Product::orderBy('num_of_sale', 'desc')->where('is_accepted', 1);
        // $products=$products->groupBy('variation_id');

        // dd($products);
        return new ProductCollection($products->limit(20)->get());
    }

    public function related($id)
    {
        return $this->admin();
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
        return $this->admin();
        return new ProductCollection(Product::inRandomOrder()->take(50)->get());
    }

    public function freeShippingProduct()
    {
        return $this->admin();
        return response()->json([
            'products' => new ProductCollection(Product::where('delivery_group_id', 0)->inRandomOrder()->limit(12)->get())
        ]);
    }

    public function byBrand($name)
    {
        $brand = Brand::select('*')->where('slug', $name)->get();
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

    public function getAllBySlug($type,Request $request){
        $response = "";
        switch ($type){
            case "category" :
                if(!$category = Category::select(['id','level'])->where('slug',$request->id)->firstOrFail()){
                    break;
                }
                $ids = Category::descendantsAndSelf($category->id)->where('level','=', 2)->map(function ($category) {
                    return $category->id;
                });
                $products = Product::whereIn('subsubcategory_id',$ids);

                $response = $this->searchPr($type,$products,$request);
                break;
            case "brand" :
                if(!$brand = Brand::select('id')->where('slug',$request->id)->firstOrFail()){
                    break;
                }
                $products = Product::where('brand_id',$brand->id);
                $response = $this->searchPr($type,$products,$request);
                break;
            case "seller" :
                if(!$seller = Shop::select('user_id')->where('slug',$request->id)->firstOrFail()){
                    break;
                }

                $products = Product::where('user_id',$seller->user_id);
                $response = $this->searchPr($type,$products,$request);
                break;
            case "flashdeals" :
                if(!$flash_deal = FlashDeal::where('slug', $request->id)->firstOrFail()){
                    break;
                }
                $ids = FlashDealProduct::where('flash_deal_id',$flash_deal->id)->pluck('product_id');
                $products = Product::whereIn('id',$ids);
                $response = $this->searchPr($type,$products,$request);
                break;
        }

        return $response;
    }

    public function searchPr($type,$products,$request)
    {
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $original_min_price=$products->min('unit_price');
        $original_max_price=$products->max('unit_price');
//        $query = $request->q;
        if ($products != null){
            if($min_price != null){
                $products = $products->where('unit_price', '>=', $min_price);
            }

            if($max_price != null){
                $products = $products->where('unit_price', '<=', $max_price);
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
//            if($query != null){
//                $searchController = new SearchController;
//                $searchController->store($request);
//                $products = $products->where('name', 'like', '%'.$query.'%')->orWhere('tags', 'like', '%'.$query.'%');
//            }

            if ($request->brand != null) {
                $brand_id = (\App\Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
                if($brand_id)$products = $products->where('brand_id', $brand_id);
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
                    if ($request->has('attribute_' . $attribute['id'])) {
                        foreach ($request['attribute_' . $attribute['id']] as $key => $value) {
                            $str = '"' . $value . '"';
                            $products = $products->where('choice_options', 'like', '%' . $str . '%');
                        }

                        $item['id'] = $attribute['id'];
                        $item['values'] = $request['attribute_' . $attribute['id']];
                        array_push($selected_attributes, $item);
                    }
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
            //Новинки
            if ($request->has('new') && $request->new) {
                $products = $products->where('todays_deal', 1);
            }
            //Популярные
            if ($request->has('popular') && $request->popular) {
                $products = $products->where('featured', 1);
            }
            //Рекомендуемые
            if ($request->has('recommendation') && $request->recommendation) {
                $products = $products->where('seller_featured', 1);
            }
            //Акции
            if ($request->has('stock') && $request->stock) {
                $products = $products->where('discount','>', 0);
            }
            //Бесплатная доставка
            if ($request->has('freeDelevery') && $request->freeDelevery) {
                $products = $products->where('shipping_type', 'free');
            }
            //Доступно в рассрочку
            if ($request->has('installment') && $request->installment) {
//                $products = $products->where('shipping_type', 'free');
            }
            //Brand
//            if ($request->has('brand') && $name=$request->brand) {
//                $brand = Brand::select('*')->where('slug', $name)->firstOrFail();
//                $products =$products->where('brand_id', $brand->id);
//            }

            $products = filter_products($products)->paginate(12)->appends(request()->query());

            return response()->json([
                'products' => new ProductCollection($products),
                'attributes' => $attributes,
                'min_price'=>$original_min_price,
                'max_price'=>$original_max_price,
                'type' => $type
            ]);
        }else {
            return response()->json([
                'products' => [],
                'attributes' => [],
                'min_price'=>null,
                'max_price'=>null,
                'type' => $type
            ]);
        }


    }

    public function filterPublishedProduct($products, $conditions){
        if(count($conditions)>0){
            return $products->where([['qty', '>', 0],['is_accepted', 1],['published', 1]])->where($conditions);
        }
        return $products->where([['qty', '>', 0],['is_accepted', 1],['published', 1]]);
    }

    public function filterProductByVariation($variations, $conditions){
        if(count($conditions)>0){
            return $variations->where($conditions);
        }
        return $variations;
    }

    //Getting elements and filtering by product $conditions=array(['todays_deal', 1])
    public function getIndexPageProducts($product_conditions){
        $products=Product::where('variation_id', '<>', null);
        $products=$this->filterPublishedProduct($products, $product_conditions)->get();
        $variations=$products->groupBy('variation_id');
        $variations_arr=collect();
        $elements_arr=collect();
        foreach($variations as $variation_id=>$models){
            $variations_arr->push(Product::where('variation_id',$variation_id)->inRandomOrder()->first());
        }
        $elements=$variations_arr->groupBy('element_id');
        foreach($elements as $element_id=>$models){
            $elements_arr->push(Product::where('element_id',$element_id)->inRandomOrder()->first());
        }
        return new ProductCollection($elements_arr);
    }

}
