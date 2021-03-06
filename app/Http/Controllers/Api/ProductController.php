<?php

namespace App\Http\Controllers\Api;

// use App\Http\Controllers\SearchController;
// use App\Http\Resources\CategoryCollection;
// use App\Http\Resources\FlashDealProductCollection;
// use App\Http\Resources\FreeShippingProductsCollection;

use App\Address;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailCollection;
use App\Http\Resources\SearchProductCollection;
use App\Http\Resources\FlashDealCollection;
use App\Http\Resources\FlashDealsCollection;
use App\Attribute;
use App\Brand;
use App\Category;
use App\Characteristic;
use App\City;
use App\FlashDeal;
use App\FlashDealProduct;
use App\Product;
use App\Shop;
use App\Color;
use App\Delivery;
use App\Element;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\ElementCollection;
use App\Http\Resources\ParentCategoryCollection;
use App\Http\Resources\ProductColorCollection;
use App\Http\Resources\SearchCityCollection;
use App\Http\Resources\VariationCollection;
use App\IpAddress;
use App\User;
// use App\Seller;
use Illuminate\Http\Request;
use App\Utility\CategoryUtility;
use App\Variation;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


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
        return new ProductCollection(getPublishedProducts('product', ['where' => [['name', 'like', '%' . $request->get('q') . '%']]])->get());
    }

    public function index()
    {
        return new ProductCollection(getPublishedProducts('element')->paginate(10));
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
        $product = null;
        $product_collection = null;
        $breadcrumbs[] = null;
        if ($product = Product::where('slug', $id)->first()) {
            $variation = $product->variation;
            $element = Element::findOrFail($variation->element_id);
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
            $product_collection = new ProductDetailCollection($product);
        }
        // dd($product);
        return [
            'product' => $product_collection,
            'breadcrumbs' => $breadcrumbs
        ];
    }

    public function admin()
    {
        // return getProductAttributes(getPublishedProducts('product', ['where' => [['added_by', 'admin']]])->get());
        return new ProductCollection(getPublishedProducts('product', ['where' => [['added_by', 'admin']]])->paginate(10));
    }

    public function seller()
    {
        return new ProductCollection(getPublishedProducts('product', ['where' => [['added_by', 'seller']]])->paginate(10));
        // return $this->admin();
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
        $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
        $product_conditions['where'][] = ['published', 1];
        // $product_conditions['where'][]=['featured',1];
        // $product_conditions[] = 'random';
        //Filtering by category slug
        $element_conditions['whereIn'][] = ['category_id' => $category_ids];

        //Filtering by brand slug
        if ($request->brand != null) {
            $brand_id = (\App\Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            if ($brand_id) $element_conditions['where'][] = ['brand_id', $brand_id];
        }
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

        //??????????????
        if ($request->has('new') && $request->new) {
            $product_conditions['where'][] = ['todays_deal', 1];
        }
        //????????????????????
        if ($request->has('popular') && $request->popular) {
            $product_conditions['where'][] = ['featured', 1];
        }
        //??????????????????????????
        if ($request->has('recommendation') && $request->recommendation) {
            $product_conditions['where'][] = ['seller_featured', 1];
        }
        //??????????
        if ($request->has('stock') && $request->stock) {
            $product_conditions['where'][] = ['discount', '>', 0];
        }
        //???????????????????? ????????????????
        if ($request->has('freeDelevery') && $request->freeDelevery) {
            $product_conditions['where'][] = ['delivery_type', 'free'];
        }
        //???????????????? ?? ??????????????????
        if ($request->has('installment') && $request->installment) {
            $product_conditions['where'][] = ['delivery_type', 'free'];
        }

        // $products = Product::where('element_id', '<>', null);
        // $products = filterProductByRelation($products, 'product', $product_conditions);
        // $products = filterProductByRelation($products, 'element', $element_conditions);
        // $products = filter_products($products)->paginate(10)->appends(request()->query());
        return new ProductCollection(getPublishedProducts('element', $product_conditions, [], $element_conditions)->inRandomOrder()->paginate(12));
    }

    public function featuredCategoryProducts($slug)
    {
        // return $this->admin();
        if (!$slug) {
            abort(404);
        }
        $categoryA = Category::where('slug', $slug)->firstOrFail();
        $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
        // $product_conditions['where'][] = ['published', 1];
        $product_conditions['where'][] = ['featured', 1];
        // $product_conditions[] = 'random';
        //Filtering by category slug
        $element_conditions['whereIn'][] = ['category_id' => $category_ids];


        // $products = Product::where('element_id', '<>', null);
        // $products = filterProductByRelation($products, 'product', $product_conditions);
        // $products = filterProductByRelation($products, 'element', $element_conditions);

        return new ProductCollection(getPublishedProducts('element', $product_conditions, [], $element_conditions)->inRandomOrder()->paginate(12));
    }

    public function subCategory($id)
    {
        if (!$id) {
            abort(404);
        }
        $categoryA = Category::where('slug', $id)->firstOrFail();
        $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
        // $product_conditions['where'][] = ['published', 1];
        // $product_conditions['where'][] = ['is_accepted', 1];
        $product_conditions[] = 'random';
        //Filtering by category slug
        $element_conditions['whereIn'][] = ['category_id' => $category_ids];

        // $products = Product::where('element_id', '<>', null);
        // $products = filterProductByRelation($products, 'product', $product_conditions);
        // $products = filterProductByRelation($products, 'element', $element_conditions);

        return new ProductCollection(getPublishedProducts('element', $product_conditions, [], $element_conditions)->inRandomOrder()->paginate(12));
    }

    public function subSubCategory($id)
    {
        // return $this->admin();
        // $category_ids = CategoryUtility::children_ids($id);
        // $category_ids[] = $id;
        if (!$id) {
            abort(404);
        }
        $categoryA = Category::where('slug', $id)->firstOrFail();
        $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
        $product_conditions['where'][] = ['published', 1];
        $product_conditions['where'][] = ['is_accepted', 1];
        // $product_conditions[] = 'random';
        //Filtering by category slug
        $element_conditions['whereIn'][] = ['category_id' => $category_ids];

        // $products = Product::where('element_id', '<>', null);
        // $products = filterProductByRelation($products, 'product', $product_conditions);
        // $products = filterProductByRelation($products, 'element', $element_conditions);

        return new ProductCollection(getPublishedProducts('element', $product_conditions, [], $element_conditions)->inRandomOrder()->paginate(12));
    }

    public function brand($id)
    {
        return new ProductCollection(getPublishedProducts('element', [], [], ['where' => [['brand_id', $id]]])->paginate(12));
    }

    public function todaysDeal()
    {
        return new ProductCollection(getPublishedProducts('element', [], [], ['where' => [['todays_deal', 1]]])->paginate(12));
    }

    public function newProducts()
    {
        return new ProductCollection(getPublishedProducts('element', ['orderBy' => [['created_at' => 'desc']]], [], [])->paginate(12));
    }

    public function flashDeal()
    {
        // return $this->admin();
        $flash_deals = FlashDeal::where('status', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
        return new FlashDealsCollection($flash_deals);
    }

    public function singleFlashDeal($id)
    {
        // return $this->admin();
        $flash_deal = FlashDeal::where('slug', $id)->firstOrFail();
        return new FlashDealCollection($flash_deal);
    }

    public function featured()
    {
        return new ProductCollection(getPublishedProducts('element', [], [], ['where' => [['featured', 1]]])->inRandomOrder()->paginate(12));

        // return new ProductCollection(Product::where('featured', 1)->where('is_accepted', 1)->inRandomOrder()->get());
    }

    public function featuredFlashDeals()
    {
        $flash_deals = FlashDeal::where('featured', 1)->where('status', 1)->where('start_date', '<=', strtotime(date('d-m-Y')))->where('end_date', '>=', strtotime(date('d-m-Y')))->get();
        return new FlashDealsCollection($flash_deals);
    }

    public function singleFeaturedFlashDeal($id)
    {
        $flash_deal = FlashDeal::where('featured', 1)->where('status', 1)->where('slug', $id)->firstOrFail();
        return new FlashDealCollection($flash_deal);
    }

    public function bestSeller()
    {
        return new ProductCollection(getPublishedProducts('element', ['orderBy' => [['num_of_sale' => 'desc']]], [], [])->paginate(12));
    }

    public function related($id)
    {
        if ($product = Product::where('id', $id)->first()) {
            return new ProductCollection(getPublishedProducts('variation', ['where' => [['id', '<>', $product->id]]], [], ['where' => [['category_id', $product->element->category_id]], 'random'])->inRandomOrder()->paginate(12));
        }
        return [];
        return response()->json([
            'message' => translate('???????????? ???????????????? ???? ????????????????????.')
        ], 404);
    }

    public function topFromSeller($id)
    {
        $product = Product::find($id);
        return new ProductCollection(getPublishedProducts('product', ['where' => [['user_id', $product->user_id]], 'random', 'orderBy' => [['num_of_sale' => 'desc']]], [], [])->limit(4)->get());
    }

    public function search()
    {
        $key = request('key');
        $scope = request('scope');

        switch ($scope) {

            case 'price_low_to_high':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orderBy('price', 'asc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            case 'price_high_to_low':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orderBy('price', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            case 'new_arrival':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orderBy('created_at', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            case 'popularity':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orderBy('num_of_sale', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;

            case 'top_rated':
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orderBy('rating', 'desc')->paginate(10)); ///->orWhere('tags', 'like', "%{$key}%")
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
                $collection = new SearchProductCollection(Product::where('name', 'like', "%{$key}%")->orderBy('num_of_sale', 'desc')->paginate(10));
                $collection->appends(['key' => $key, 'scope' => $scope]);
                return $collection;
        }
    }

    public function variantPrice(Request $request)
    {
        $product = Product::findOrFail($request->id);
        $str = $product->name;
        $tax = 0;

        // if ($request->has('color')) {
        //     $data['color'] = $request['color'];
        //     $str = Color::where('code', $request['color'])->first()->name;
        // }

        // foreach (json_decode($request->choice) as $option) {
        //     $str .= $str != '' ? '-' . str_replace(' ', '', $option->name) : str_replace(' ', '', $option->name);
        // }


        $price = $product->price;
        $stockQuantity = $product->qty;

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
            'price' => (float)$price,
            'in_stock' => $stockQuantity < 1 ? false : true
        ]);
    }

    public function home()
    {
        return new ProductCollection(getPublishedProducts('element')->take(50)->get());
    }

    public function freeShippingProduct()
    {
        return new ProductCollection(getPublishedProducts('element', ['where' => [['delivery_type', 'free']]], [], [])->inRandomOrder()->paginate(12));
    }

    public function byBrand($name)
    {
        $brand = Brand::where('slug', $name)->first();
        $element_conditions['where'][] = ['brand_id', $brand->id];
        $product_conditions['orderBy'][] = ['num_of_sale' => 'desc'];
        $products = getPublishedProducts('element', $product_conditions, [], $element_conditions)->paginate(12);
        $min_price = ($products->count() > 0) ? homeDiscountedBasePrice($products[0]->id) : 0;
        $max_price = ($products->count() > 0) ? homeDiscountedBasePrice($products[0]->id) : 0;
        foreach ($products as $product) {
            $unit_price = homeDiscountedBasePrice($product->id);
            if ($min_price > $unit_price) {
                $min_price = $unit_price;
            }
            if ($max_price < $unit_price) {
                $max_price = $unit_price;
            }
        }

        return json_encode(array(
            'id' => $brand->id,
            'name' => $brand->name,
            'min_price' => $min_price,
            'max_price' => $max_price,
            'products' => new ProductCollection($products)
        ));
    }

    public function getAllBySlug($type, Request $request)
    {
        try {
            // $products = getPublishedProducts('product');//Product::where('variation_id', '<>', null);
            $result =  $this->searchPr($type, $request);
        } catch (\Exception $e) {
            return [
                'message' => $e->getMessage()
            ];
        }
        return $result;
    }
    public function getCategoryProducts($id)
    {
        $category = Category::where('id', $id)->orWhere('slug', $id)->first();
        $category_ids = Category::descendantsAndSelf($category->id)->where('level', '=', 2)->pluck('id');
        $product_ids = [];
        if (count($category_ids) > 0) {
            $element_ids = Element::whereIn('category_id', $category_ids)->pluck('id') ?? [];
            $product_ids = Product::whereIn('element_id', $element_ids)->pluck('id');
        }
        return $product_ids;
    }
    public function getBrandProducts($id)
    {
        $brand_ids = Brand::where('id', $id)->orWhere('slug', $id)->pluck('id');
        $product_ids = [];
        if (count($brand_ids) > 0) {
            $element_ids = Element::whereIn('brand_id', $brand_ids)->pluck('id') ?? [];
            $product_ids = Product::whereIn('element_id', $element_ids)->pluck('id');
        }
        return $product_ids;
    }
    public function searchPr($type, $request)
    {
        $product_conditions = [];
        $element_conditions = [];
        $is_random = true;
        $product_type = null;
        // dd($request->all());
        //Filtering by brand slug
        switch ($type) {
            case 'brand':
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getBrandProducts($request->id)];
                }
                break;
            case 'element':
                $product_type = 'element';
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->id)];
                }
                break;
            case 'variation':
                $product_type = 'variation';
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->id)];
                }
                break;
            case 'flashdeals':
                if ($request->id != "list" && $flash_deal = FlashDeal::where('slug', $request->id)->firstOrFail()) {
                    $product_ids = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->pluck('product_id');
                    $product_conditions['whereIn'][] = ['id' => $product_ids];
                }
                break;
            case 'category':
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->id)];
                }
                break;
            case 'categoryAll':
                $element_conditions['where'][] = ['category_id', '<>', null];
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->id)];
                }
                break;
            case 'categoryPopular':
                $product_conditions['where'][] = ['todays_deal', 1];
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->id)];
                }
                break;
            case 'seller':
                if ($seller = Shop::select('user_id')->where('slug', $request->id)->firstOrFail()) {
                    $product_conditions['where'][] = ['user_id', $seller->user_id];
                }
                break;
            case 'new':
                $product_conditions['orderBy'][] = ['created_at' => 'desc'];
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->id)];
                }
                $is_random = false;
                break;
            case 'todays_deal':
                $product_conditions['where'][] = ['todays_deal', 1];
                break;
            case 'popular':
                $product_conditions['where'][] = ['todays_deal', 1];
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->id)];
                }
                break;
            case 'recommendation':
                $product_conditions['where'][] = ['featured', 1];
                if ($request->id != "list") {
                    $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->id)];
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
        $products_count = getPublishedProducts('product', $product_conditions, [], $element_conditions)->count();
        $attribute_product_conditions = $product_conditions;
        $attribute_element_conditions = $element_conditions;
        //Order by sorting type
        $sort_by = $request->sort_by;
        if ($sort_by != null) {
            $is_random = false;
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
        //Category
        if ($request->has('category') && $request->category) {
            $product_conditions['whereIn'][] = ['id' => $this->getCategoryProducts($request->category)];
            // if ($categoryA = Category::where('slug', $request->category)->firstOrFail()) {
            //     $category_ids = Category::descendantsAndSelf($categoryA->id)->where('level', '=', 2)->pluck('id');
            //     $element_conditions['whereIn'][] = ['category_id' => $category_ids];
            // }
        }
        //??????????????
        if ($request->has('new') && $request->new) {
            $is_random = false;
            $product_conditions['orderBy'][] = ['created_at' => 'desc'];
        }
        //Deal
        if ($request->has('todaysDeal') && $request->new) {
            $product_conditions['where'][] = ['todays_deal', 1];
        }
        //????????????????????
        if ($request->has('popular') && $request->popular) {
            $product_conditions['where'][] = ['todays_deal', 1];
        }
        //??????????????????????????
        if ($request->has('recommendation') && $request->recommendation) {
            $product_conditions['where'][] = ['featured', 1];
        }
        //??????????
        if ($request->has('stock') && $request->stock) {
            $product_conditions['where'][] = ['discount', '>', 0];
        }
        //???????????????????? ????????????????
        if ($request->has('freeDelevery') && $request->freeDelevery) {
            $product_conditions['where'][] = ['delivery_type', 'free'];
        }
        //???????????????? ?? ??????????????????
        if ($request->has('installment') && $request->installment) {
            $product_conditions['where'][] = ['delivery_type', 'free'];
        }

        if ($request->has('brand') && $request->brand) {
            $product_conditions['whereIn'][] = ['id' => $this->getBrandProducts($request->id)];
        }

        if ($request->has('q') && $query = $request->q) {
            $is_random = false;
            // $searchController = new SearchController;
            // $searchController->store($request);
            $product_conditions['where'][] = ['name', 'like', '%' . $query . '%'];
            // $element_conditions['where'][] = ['tags', 'like', '%' . $query . '%'];
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
        $products = getPublishedProducts('product', $product_conditions, [], $element_conditions, $is_random);
        $attribute_products = getPublishedProducts('product', $attribute_product_conditions, [], $attribute_element_conditions, $is_random);
        //Attribute collection
        $all_attributes = array();
        $all_characteristics = array();
        $tmp_products = $attribute_products->get();
        foreach ($tmp_products as $product) {
            if ($product->variation)
                $all_characteristics = array_unique(array_merge($all_characteristics, explode(',', $product->variation->characteristics)));
        }
        foreach ($all_characteristics as $characteristic) {
            if ($item = Characteristic::where('id', $characteristic)->first())
                $all_attributes[$item->attribute_id][] = $characteristic;
        }
        $all_attributes = getAttributeFormat($all_attributes);

        //Color Collection
        $all_colors = array();
        $brands = [];
        $brand_ids = [];
        foreach ($tmp_products as $product) {
            if (($product->variation)  && $product->variation->color_id != null) {
                $all_colors[] = $product->variation->color_id;
            }
            $brand_ids[] = $product->element->brand->id;
        }
        $all_colors = array_unique($all_colors);

        if (count($brand_ids) > 0) {
            $brands = Brand::whereIn('id', $brand_ids)->get();
        }
        $product_ids = [];
        foreach ($tmp_products as $product) {
            $unit_price = homeDiscountedBasePrice($product->id);
            if ($request->has('min_price') && $selected_min_price = (float)$request->min_price) {
                if ($unit_price < $selected_min_price) {
                    continue;
                }
            }
            if ($request->has('max_price') && $selected_max_price = (float)$request->max_price) {
                if ($unit_price > $selected_max_price) {
                    continue;
                }
            }
            $product_ids[] = $product->id;
        }
        $products = $products->whereIn('id', $product_ids);

        $prices = [];
        foreach ($tmp_products as $product) {
            $prices[] = homeDiscountedBasePrice($product->id);
        }

        $min_price = (count($prices) > 0) ? min($prices) : 0;
        $max_price = (count($prices) > 0) ? max($prices) : 0;
        if ($product_type == null) {
            if ($request->has('product_type')) {
                $product_type = $request->product_type;
                if ($product_type == 'variation') {
                    $products = groupByDistinctRelation($products, 'variation_id', $is_random);
                } else if ($product_type == 'element') {
                    $products = groupByDistinctRelation($products, 'element_id', $is_random);
                }
            } else {
                $product_type = 'product';
            }
        }

        $sub_sub_category_ids = [];
        foreach ($tmp_products as $product) {
            $sub_sub_category_ids[] = $product->element->category->id;
        }
        $sub_sub_category_ids = array_unique($sub_sub_category_ids);
        $sub_sub_categories = Category::whereIn('id', $sub_sub_category_ids)->where('level', 2)->get();
        // $all_categories = getProductCategories($attribute_products, 0)->get();
        $products = $products->paginate(50);
        return response()->json([
            // 'categories' => new CategoryCollection($all_categories),
            'categories' => new ParentCategoryCollection($sub_sub_categories),
            'products' => new ProductCollection($products),
            'products_count' => $products_count ?? count($products),
            'attributes' => $all_attributes,
            'colors' => new ProductColorCollection($all_colors),

            'brands' => (count($brands) > 0) ? new BrandCollection($brands) : [],
            'min_price' => $min_price ?? null,
            'max_price' => $max_price ?? null,
            'selected_min_price' => (isset($selected_min_price)) ? $selected_min_price : $min_price,
            'selected_max_price' => (isset($selected_max_price)) ? $selected_max_price : $max_price,
            'type' => $type ?? null,
            'product_type' => $product_type,
        ]);
    }

    // public function calculateDeliveryCost(Request $request){
    //     $user=User::findOrFail($request->user_id);
    //     $product=Product::findOrFail($request->product_id)->user();
    //     $seller=$product->user();
    //     $user_address=$user->addresses()->where('set_default', 1)->first();
    //     $seller_address=$seller->addresses()->where('set_default', 1)->first();
    //     $distance=$this->calculateDistance($user_address->latitude,$user_address->longitude,$seller_address->latitude,$seller_address->longitude );
    //     $delivery_metrics=Delivery::orderBy('distance', 'asc')->where('distance', '>', $distance)->first();
    //     $weight_price=\App\SellerSetting::where('type', 'kg_weight_price')->where('user_id', $seller->id)->first()->value;
    //     $delivery_cost= $delivery_metrics->price*$distance+$weight_price*$product->weight;
    //     return $delivery_cost;
    // }
    // public function calculateDistance($from_lat, $from_long, $to_lat, $to_long){
    //     return 10;
    // }

    // function calculateShipping(Request $request){
    //     $product=Product::find($request->product_id);
    //     if($request->has('type') && $request->type='precise' && $request->has('address_id')){
    //         return calculateDeliveryCost($product, $request->address_id);
    //     }else{
    //         $user_region=City::where('id', $request->region_id)->where('type', 'region');
    //         $address=Address::firstOrNew(['region_id'=>$user_region->id]);
    //         $address->save();
    //         return calculateDeliveryCost($product, $address->id);;
    //     }
    //     return 0;
    // }
    public function setLocationSetting(Request $request)
    {
        $client_ip = getClientIp();
        $ip_address = IpAddress::firstOrNew(['ip' =>  $client_ip]);
        if ($request->has('region_id')) {
            $ip_address->region_id = $request->region_id;
        }
        if ($request->has('language_id')) {
            $ip_address->language_id = $request->language_id;
        }
        if ($request->has('city_id')) {
            $ip_address->city_id = $request->city_id;
        }
        if ($request->has('data')) {
            $ip_address->data = $request->data;
        }
        $ip_address->save();
        $address = getUserAddress();
        return new SearchCityCollection(City::where('id', $address->city_id)->get());
        // return response()->json(getUserAddress());
    }

    public function getLocationSetting()
    {
        $address = getUserAddress();
        $cities=City::where('id', $address->city_id)->get();
        foreach($cities as $city){
            $city->address=json_encode($address);
            $city->is_registered=($address->user_id!=0)?true:false;
        }
        return new SearchCityCollection($cities);
        // return response()->json(getUserAddress());
    }

    public function checkProductExists(Request $request)
    {
        //?ids[]=2&ids[]=5
        // data [2 => 0, 5=>6]
        $ids = [];
        $ids = $request->ids;
        $products = filterPublishedProducts(Product::whereIn('id', $ids))->get();
        $data = [];
        foreach ($products as $product) {
            $preparation_days=\App\SellerSetting::where('type', 'product_preparation_days')->where('user_id', $product->user_id)->first()->value??0;
            $data[] = [
                    'id'=>$product->id ,
                    'slug'=>$product->slug ,
                    'quantity' => $product->qty,
                    'address' => $product->address,
                    'region'=>$product->address->region,
                    'city'=>$product->address->city,
                    'country'=>$product->address->city->country,
                    'seller_name' => $product->user->name,
                    'shop_slug' => $product->added_by == 'admin' ? '' : $product->user->shop->slug,
                    'preparation_days'=>$preparation_days,
            ];
        }
        return response()->json([
            'data' => $data
        ]);
    }
}
