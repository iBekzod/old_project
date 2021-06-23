<?php

namespace App\Http\Controllers;

use Cviebrock\EloquentSluggable\Services\SlugService;
use App\HelperClasses\Translations;
use App\CharacteristicValues;
use App\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Session;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\FlashDeal;
use App\Brand;
use App\Product;
use App\PickupPoint;
use App\CustomerPackage;
use App\CustomerProduct;
use App\User;
use App\Seller;
use App\Shop;
use App\Color;
use App\Order;
use App\BusinessSetting;
use App\Category;
use App\Element;
use App\Http\Controllers\SearchController;
use ImageOptimizer;
use Cookie;
use Illuminate\Support\Str;
use App\Mail\SecondEmailVerifyMailManager;
use Mail;
use App\Utility\TranslationUtility;
use App\Utility\CategoryUtility;
use Illuminate\Auth\Events\PasswordReset;


class HomeController extends Controller
{

    public function return_back()
    {
        redirect()->back();
    }

    public function login()
    {
        if(Auth::check()){
            return redirect()->route('admin');
        }
        return $this->admin_dashboard();
    }

       // TODO::AUTHcontroller  Home controller;
       public function seller_registration(Request $request)
       {

           if ($request->method() === 'POST') {

                    $request->validate([
                        'name' => 'required|min:3',
                        'phone' => 'required|max:9|unique:users',
                        'country_code' => 'required',
                        'email' => 'required|unique:users|max:255',
                        'password' => 'required|min:6',
                        'password_confirmation'=> 'required'
                    ]);

                    $user = new User;
                    $user->name = $request->name;
                    $user->phone =$request->phone;
                    $user->email = $request->email;
                    $user->registration_step='active_1';
                    $user->user_type = "seller";
                    $user->email_verified_at = now();
                    $user->password = Hash::make($request->password);
                    // $user->save();
                    if($user->save()){
                        return view('frontend.user.seller.form_second')->with('user_id',$user->id);
                        // return 'keldi';
                    }
            }
            else if($request->method() === 'GET'){
            //    if(Auth::check()){
            //        return redirect()->route('admin');
            //    }

                  return view('frontend.user_registration');
           }
           return back();
        }

    public function seller_login(Request $request)
    {

        if ($request->method() === 'POST') {


        //     $user = $request->user();
        //     $user->registration_step='active';
        //     $user->save();

        //     if ($user->registration_step=='active') {
        //         return redirect()->route('user.registration');
        //        // return 'keldi';
        //    }
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ]);


            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)){
                return back();
            }

            $user = $request->user();
            if ($user->registration_step=='active_1') {
                 return redirect()->route('user.autoidentification');
                // return 'keldi';
            }
        //     if ($user->registration_step=='active_2') {
        //         return redirect()->route('user.autoidentification');
        //    }
        //    if ($user->registration_step=='active_3') {
        //     return redirect()->route('seller.login');
        //    }
        //    if ($user->registration_step=='active_4') {
        //     return redirect()->route('seller.login');
        //    }


            auth()->login($user, true);
            return view('frontend.user.seller.dashboard');

                // if($user=User::where('email', $request->email)->where('password', bcrypt($request->password))->first()){
                //    auth()->login($user, true);
                //    return view('frontend.user.seller.dashboard');
                // }
                // else{
                //     return 'error';
                // }
        }else if($request->method() === 'GET'){
                    // if(Auth::check()){
                    //     return redirect()->route('home');
                    // }
                    // dd("sadfafguyasdgfd");
                      return view('frontend.user_login');
        }
                return back();
    }



    public function cart_login(Request $request)
    {
        $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        if($user != null){
            if(Hash::check($request->password, $user->password)){
                if($request->has('remember')){
                    auth()->login($user, true);
                }
                else{
                    auth()->login($user, false);
                }
            }
            else {
                flash(translate('Invalid email or password!'))->warning();
            }
        }
        return back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard()
    {
        return view('backend.dashboard');
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if(Auth::user()->user_type == 'seller'){
            return view('frontend.user.seller.dashboard');
        }
        else if(Auth::user()->user_type == 'admin'){
            return $this->admin_dashboard();
        }
        // elseif(Auth::user()->user_type == 'customer'){
        //     return view('frontend.user.customer.dashboard');
        // }
        else {
            return $this->admin_dashboard();
            // abort(404);
        }
    }

    public function profile(Request $request)
    {
        if(Auth::user()->user_type == 'customer'){
            $addresses=Auth::user()->addresses;
            return view('frontend.user.customer.profile', compact('addresses'));
        }
        elseif(Auth::user()->user_type == 'seller'){
            $addresses=Auth::user()->addresses;
            return view('frontend.user.seller.profile', compact('addresses'));
        }
    }

    public function customer_update_profile(Request $request)
    {
        if(env('DEMO_MODE') == 'On'){
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $request->photo;

        if($user->save()){
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }


    public function seller_update_profile(Request $request)
    {
        if(env('DEMO_MODE') == 'On'){
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $request->photo;

        $seller = $user->seller;
        $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
        $seller->bank_payment_status = $request->bank_payment_status;
        $seller->bank_name = $request->bank_name;
        $seller->bank_acc_name = $request->bank_acc_name;
        $seller->bank_acc_no = $request->bank_acc_no;
        $seller->bank_routing_no = $request->bank_routing_no;

        if($user->save() && $seller->save()){
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // return redirect('https://marketpro.vercel.app/');
        // return view('frontend.index');
        if(auth()->user() != null){
            return $this->dashboard();
        }
        return redirect()->route('login');
    }

    public function home(){
        return redirect(default_website());
    }

    public function single_product($slug){
        return redirect(default_website().'product/'.$slug);
    }

    public function flash_deal_details($slug)
    {
        $flash_deal = FlashDeal::where('slug', $slug)->first();
        if($flash_deal != null)
            return view('frontend.flash_deal_details', compact('flash_deal'));
        else {
            abort(404);
        }
    }

    public function load_featured_section(){
        return view('frontend.partials.featured_products_section');
    }

    public function load_best_selling_section(){
        return view('frontend.partials.best_selling_section');
    }

    public function load_home_categories_section(){
        return view('frontend.partials.home_categories_section');
    }

    public function load_best_sellers_section(){
        return view('frontend.partials.best_sellers_section');
    }

    public function trackOrder(Request $request)
    {
        if($request->has('order_code')){
            $order = Order::where('code', $request->order_code)->first();
            if($order != null){
                return view('frontend.track_order', compact('order'));
            }
        }
        return view('frontend.track_order');
    }

    public function product(Request $request, $slug)
    {
        $detailedProduct  = Product::where('slug', $slug)->first();

        if($detailedProduct!=null && $detailedProduct->published){
            //updateCartSetup();
            if($request->has('product_referral_code')){
                Cookie::queue('product_referral_code', $request->product_referral_code, 43200);
                Cookie::queue('referred_product_id', $detailedProduct->id, 43200);
            }
            if($detailedProduct->digital == 1){
                return view('frontend.digital_product_details', compact('detailedProduct'));
            }
            else {
                return view('frontend.product_details', compact('detailedProduct'));
            }
            // return view('frontend.product_details', compact('detailedProduct'));
        }
        abort(404);
    }

    public function element(Request $request, $slug)
    {
        $detailedProduct  = Element::where('slug', $slug)->first();

        if($detailedProduct!=null && $detailedProduct->published){
            //updateCartSetup();
            if($request->has('product_referral_code')){
                Cookie::queue('product_referral_code', $request->product_referral_code, 43200);
                Cookie::queue('referred_product_id', $detailedProduct->id, 43200);
            }
            if($detailedProduct->digital == 1){
                return view('frontend.digital_product_details', compact('detailedProduct'));
            }
            else {
                return view('frontend.product_details', compact('detailedProduct'));
            }
            // return view('frontend.product_details', compact('detailedProduct'));
        }
        abort(404);
    }
    public function shop($slug)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null){
            $seller = Seller::where('user_id', $shop->user_id)->first();
            if ($seller->verification_status != 0){
                return view('frontend.seller_shop', compact('shop'));
            }
            else{
                return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
            }
        }
        abort(404);
    }

    public function filter_shop($slug, $type)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null && $type != null){
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        abort(404);
    }

    public function all_categories(Request $request)
    {
        $categories = Category::where('level', 0)->orderBy('name', 'asc')->get();
        return view('frontend.all_category', compact('categories'));
    }
    public function all_brands(Request $request)
    {
        $categories = Category::all();
        return view('frontend.all_brand', compact('categories'));
    }

    public function characteristics(Request $request, $id)
    {
        if ($request->method() === 'POST') {
            $product = Product::where('id', $id)->firstOrFail();
            $product->characteristicValues()->delete();
            if ($request->get('attr')) {
                foreach ($request->get('attr') as $item) {

                    $data = [
                        'product_id' => $product->id,
                        'parent_id' => $item['parent_id'],
                        'attr_id' => $item['id'],
                        'name' => $item['name'],
                    ];

                    if (isset($item['values'])) {
                        $data['values'] = implode(' / ', $item['values']);
                    }

                    CharacteristicValues::create($data);
                }
            }

            flash(translate('Saved successfully'))->success();
            return back();
        } else {
            $product = Product::where('id', $id)
                ->with(['characteristicValues'])
                ->firstOrFail();
            $options = $product->category->productAttributes;

            return view('frontend.user.seller.add_attr', compact(
                'product', 'options'
            ));
        }
    }

    public function show_product_clone_form(Request $request)
    {
        if($request->method() == 'POST') {
            if($request->has('product_ids')){
                $request->validate([
                    'product_ids' => 'required'
                ]);
                foreach ($product_ids=$request->product_ids as $product_id) {
                    $product = Product::find($product_id);
                    $product_translations = $product->product_translations;
                    $characteristics = CharacteristicValues::where('product_id', $product->id)->get();
                    $product_new = $product->replicate();
                    $product_new->slug = substr($product_new->slug, 0, -5).Str::random(5);
                    $product_new->user_id = Auth::user()->id;
                    $product_new->added_by = 'seller';
                    $product_new->on_moderation = 1;
                    $product_new->is_accepted = 0;
                    if($product_new->save()){
                        foreach ($product_translations as $translation) {
                            ProductTranslation::create([
                                'product_id' => $product_new->id,
                                'name' => $translation->name,
                                'lang' => $translation->lang
                            ]);
                        }
                        foreach ($characteristics as $characteristic) {
                            CharacteristicValues::create([
                                'parent_id' => $characteristic->parent_id,
                                'product_id' => $product_new->id,
                                'attr_id' => $characteristic->attr_id,
                                'name' => $characteristic->name,
                                'values' => $characteristic->values
                            ]);
                        }
                    }
                }
                flash(translate('All done'))->success();
                return back();
            }else{
                $request->validate([
                    'product_id' => 'required'
                ]);
                $product = Product::find($request->get('product_id'));
                $product_translations = $product->product_translations;
                $characteristics = CharacteristicValues::where('product_id', $product->id)->get();
                $product_new = $product->replicate();
                $product_new->slug = substr($product_new->slug, 0, -5).Str::random(5);
                $product_new->user_id = Auth::user()->id;
                $product_new->added_by = 'seller';
                $product_new->on_moderation = 1;
                $product_new->is_accepted = 0;

                if($product_new->save()){
                    foreach ($product_translations as $translation) {
                        ProductTranslation::create([
                            'product_id' => $product_new->id,
                            'name' => $translation->name,
                            'lang' => $translation->lang
                        ]);
                    }
                    foreach ($characteristics as $characteristic) {
                        CharacteristicValues::create([
                            'parent_id' => $characteristic->parent_id,
                            'product_id' => $product_new->id,
                            'attr_id' => $characteristic->attr_id,
                            'name' => $characteristic->name,
                            'values' => $characteristic->values
                        ]);
                    }
                    return redirect()->route('seller.products.edit', [$product_new->id, 'lang' => 'en']);
                }
                else{
                    flash(translate('Something went wrong'))->error();
                    return back();
                }
            }

        }
        // dd("ok");
        $products = Product::where('digital', 0)->orderBy('created_at', 'desc')->get();
        // dd($products);
        return view('frontend.user.seller.product_clone_new', compact('products'));
        // $this->clone_from_all_product_list();
        // return view('frontend.user.seller.product_clone');
    }

    public function show_product_upload_form(Request $request)
    {
        if(\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated){
     //       if(Auth::user()->seller->remaining_uploads > 0){
        $categories = Category::where('parent_id', null)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
                return view('frontend.user.seller.product_upload', compact('categories'));
     //       }
     //       else {
     //           flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
     //           return back();
     //       }
        }
        $categories = Category::where('parent_id', null)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.user.seller.product_upload', compact('categories'));
    }

    public function show_product_edit_form(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::all()->toTree();
        return view('frontend.user.seller.product_edit', compact('product', 'categories', 'tags', 'lang'));
    }

    public function seller_product_list(Request $request)
    {
        $search = null;
        $products = Product::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $products = $products->where('name', 'like', '%'.$search.'%');
        }
        $products = $products->paginate(10);
        return view('frontend.user.seller.products', compact('products', 'search'));
    }

    public function clone_from_all_product_list()
    {
        $products = Product::where('digital', 0)->orderBy('created_at', 'desc');
        return view('frontend.user.seller.product_clone', compact('products'));
    }

    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('published', 1)->where('tags', 'like', '%'.$request->search.'%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $request->search) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(Product::where('published', 1)->where('name', 'like', '%'.$request->search.'%'))->get()->take(3);

        $categories = Category::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        $shops = Shop::whereIn('user_id', verified_sellers_id())->where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        if(sizeof($keywords)>0 || sizeof($categories)>0 || sizeof($products)>0 || sizeof($shops) >0){
            return view('frontend.partials.search_content', compact('products', 'categories', 'keywords', 'shops'));
        }
        return '0';
    }

    public function listing(Request $request)
    {
        return $this->search($request);
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();

        if ($category != null) {
            return $this->search($request, $category->id);
        }

        abort(404);
    }

    public function listingByBrand(Request $request, $brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->first();
        if ($brand != null) {
            return $this->search($request, null, $brand->id);
        }
        abort(404);
    }

    public function search(Request $request, $category_id = null, $brand_id = null)
    {
        $query = $request->q;
        $sort_by = $request->sort_by;
        $min_price = $request->min_price;
        $max_price = $request->max_price;
        $seller_id = $request->seller_id;

        $conditions = ['published' => 1];

        if($brand_id != null){
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }elseif ($request->brand != null) {
            $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        }

        if($seller_id != null){
            $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
        }

        $products = Product::where($conditions);

        if($category_id != null){
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $products = $products->whereIn('category_id', $category_ids);
        }

        if($min_price != null && $max_price != null){
            $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
        }

        if($query != null){
            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name', 'like', '%'.$query.'%')->orWhere('tags', 'like', '%'.$query.'%');
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
            if($request->has('attribute_'.$attribute['id'])){
                foreach ($request['attribute_'.$attribute['id']] as $key => $value) {
                    $str = '"'.$value.'"';
                    $products = $products->where('choice_options', 'like', '%'.$str.'%');
                }

                $item['id'] = $attribute['id'];
                $item['values'] = $request['attribute_'.$attribute['id']];
                array_push($selected_attributes, $item);
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

        $selected_color = null;

        if($request->has('color')){
            $str = '"'.$request->color.'"';
            $products = $products->where('colors', 'like', '%'.$str.'%');
            $selected_color = $request->color;
        }


        $products = filter_products($products)->paginate(12)->appends(request()->query());

        return view('frontend.product_listing', compact('products', 'query', 'category_id', 'brand_id', 'sort_by', 'seller_id','min_price', 'max_price', 'attributes', 'selected_attributes', 'all_colors', 'selected_color'));
    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function top_10_settings(Request $request)
    {
        foreach (Category::all() as $key => $category) {
            if(is_array($request->top_categories) && in_array($category->id, $request->top_categories)){
                $category->top = 1;
                $category->save();
            }
            else{
                $category->top = 0;
                $category->save();
            }
        }

        foreach (Brand::all() as $key => $brand) {
            if(is_array($request->top_brands) && in_array($brand->id, $request->top_brands)){
                $brand->top = 1;
                $brand->save();
            }
            else{
                $brand->top = 0;
                $brand->save();
            }
        }

        flash(translate('Top 10 categories and brands have been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;

        if($request->has('color')){
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        if(json_decode(Product::find($request->id)->choice_options) != null){
            foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                if($str != null){
                    $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
                else{
                    $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
                }
            }
        }



        if($str != null && $product->variant_product){
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;
            $quantity = $product_stock->qty;
        }
        else{
            $price = $product->unit_price;
            $quantity = $product->current_stock;
        }

        //discount calculation
        $flash_deals = \App\FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $key => $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                if($flash_deal_product->discount_type == 'percent'){
                    $price -= ($price*$flash_deal_product->discount)/100;
                }
                elseif($flash_deal_product->discount_type == 'amount'){
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }
        if (!$inFlashDeal) {
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        if($product->tax_type == 'percent'){
            $price += ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $price += $product->tax;
        }
        return array('price' => single_price($price*$request->quantity), 'quantity' => $quantity, 'digital' => $product->digital);
    }

    public function sellerpolicy(){
        return view("frontend.policies.sellerpolicy");
    }

    public function returnpolicy(){
        return view("frontend.policies.returnpolicy");
    }

    public function supportpolicy(){
        return view("frontend.policies.supportpolicy");
    }

    public function terms(){
        return view("frontend.policies.terms");
    }

    public function privacypolicy(){
        return view("frontend.policies.privacypolicy");
    }

    public function get_pick_ip_points(Request $request)
    {
        $pick_up_points = PickupPoint::all();
        return view('frontend.partials.pick_up_points', compact('pick_up_points'));
    }

    public function get_category_items(Request $request){
        $category = Category::findOrFail($request->id);
        return view('frontend.partials.category_elements', compact('category'));
    }

    public function premium_package_index()
    {
        $customer_packages = CustomerPackage::all();
        return view('frontend.user.customer_packages_lists', compact('customer_packages'));
    }

    public function seller_digital_product_list(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)->where('digital', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.seller.digitalproducts.products', compact('products'));
    }
    public function show_digital_product_upload_form(Request $request)
    {
        if(\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated){
//            if(Auth::user()->seller->remaining_digital_uploads > 0){
                $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
                $categories = Category::where('digital', 1)->get();
                return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
//            }
//            else {
//                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
//                return back();
//            }
        }

        $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
        $categories = Category::where('digital', 1)->get();
        return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
    }

    public function show_digital_product_edit_form(Request $request, $id)
    {
        $categories = Category::where('digital', 1)->get();
        $lang = $request->lang;
        $product = Product::find($id);
        return view('frontend.user.seller.digitalproducts.product_edit', compact('categories', 'product', 'lang'));
    }

    // Ajax call
    public function new_verify(Request $request)
    {
        $email = $request->email;
        if(isUnique($email) == '0') {
            $response['status'] = 2;
            $response['message'] = 'Email already exists!';
            return json_encode($response);
        }

        $response = $this->send_email_change_verification_mail($request, $email);
        return json_encode($response);
    }


    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if(isUnique($email)) {
            $this->send_email_change_verification_mail($request, $email);
            flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            return back();
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

    public function send_email_change_verification_mail($request, $email)
    {
        $response['status'] = 0;
        $response['message'] = 'Unknown';

        $verification_code = Str::random(32);

        $array['subject'] = 'Email Verification';
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = 'Verify your account';
        $array['link'] = route('email_change.callback').'?new_email_verificiation_code='.$verification_code.'&email='.$email;
        $array['sender'] = Auth::user()->name;
        $array['details'] = "Email Second";

        $user = Auth::user();
        $user->new_email_verificiation_code = $verification_code;
        $user->save();

        try {
            Mail::to($email)->queue(new SecondEmailVerifyMailManager($array));

            $response['status'] = 1;
            $response['message'] = translate("Your verification mail has been Sent to your email.");

        } catch (\Exception $e) {
            // return $e->getMessage();
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function email_change_callback(Request $request){
        if($request->has('new_email_verificiation_code') && $request->has('email')) {
            $verification_code_of_url_param =  $request->input('new_email_verificiation_code');
            $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

            if($user != null) {

                $user->email = $request->input('email');
                $user->new_email_verificiation_code = null;
                $user->save();

                auth()->login($user, true);

                flash(translate('Email Changed successfully'))->success();
                return redirect()->route('dashboard');
            }
        }

        flash(translate('Email was not verified. Please resend your mail!'))->error();
        return redirect()->route('dashboard');

    }

    public function reset_password_with_code(Request $request){
        if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
            if($request->password == $request->password_confirmation){
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                flash(translate('Password updated successfully'))->success();

                if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')
                {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('login');
            }
            else {
                flash("Password and confirm password didn't match")->warning();
                return back();
            }
        }
        else {
            flash("Verification code mismatch")->error();
            return back();
        }
    }
}
// <<<<<<< HEAD
// // <<<<<<< HEAD
// // =======
// =======
// >>>>>>> d151758a2c8539205eb92863303565315be47a58
// <?php

// namespace App\Http\Controllers;

// use Cviebrock\EloquentSluggable\Services\SlugService;
// use App\HelperClasses\Translations;
// use App\CharacteristicValues;
// use App\ProductTranslation;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Config;
// use Session;
// use Auth;
// use Illuminate\Support\Facades\Hash;
// use App\FlashDeal;
// use App\Brand;
// use App\Product;
// use App\PickupPoint;
// use App\CustomerPackage;
// use App\CustomerProduct;
// use App\User;
// use App\Seller;
// use App\Shop;
// use App\Color;
// use App\Order;
// use App\BusinessSetting;
// use App\Element;
// use App\Http\Controllers\SearchController;
// use ImageOptimizer;
// use Cookie;
// use Illuminate\Support\Str;
// use App\Mail\SecondEmailVerifyMailManager;
// use Mail;
// use App\Utility\TranslationUtility;
// use App\Utility\CategoryUtility;
// use Illuminate\Auth\Events\PasswordReset;


// class HomeController extends Controller
// {
//     public function login()
//     {
//         if(Auth::check()){
//             return redirect()->route('admin');
//         }
//         return $this->admin_dashboard();
//     }

//     public function seller_login(Request $request)
//     {
//         // dd("fghufgss");

//         if ($request->method() === 'POST') {
//                     // dd($request->all());

//                         return response()->json([
//                             'verification_form' => json_decode(\App\BusinessSetting::where('type', 'verification_form')->first()->value)
//                         ], 200);

//                 }else if($request->method() === 'GET'){
//                     if(Auth::check()){
//                         return redirect()->route('home');
//                     }
//                     // dd("sadfafguyasdgfd");
//                       return view('frontend.user_login');
//                 }
//                 return back();
//     }
//   // TODO::AUTHcontroller  Home controller;
//     public function seller_registration(Request $request)
//     {

//     //     "_token" => "1ehPpSb1YHURcC1aAjcbo5DJkIxio19cmTtajaMB"
//     //     "name" => "Adam Hanson"
//     //     "phone" => "9577604"
//     //     "country_code" => null
//     //     "email" => null
//     //     "password" => "Pa$$w0rd!"
//     //     "password_confirmation" => "Pa$$w0rd!"
//     //     "checkbox_example_1" => "on"
//     //   ]

//         if ($request->method() === 'POST') {

//             $request->validate([
//                 // '_token'=>'required',
//                 'name' => 'required',
//                 'phone' => 'sometimes|unique:users',
//                 'country_code' => 'sometimes',
//                 'email' => 'sometimes|unique:users|max:255',
//                 'password' => 'required',
//                 'password_confirmation' => 'required',
//                  'checkbox_example_1' =>'required'
//             ]);
//         //    dd($request->all());
//             $user = new User;
//             $user->name = $request->name;
//             $user->name = $request->name.' '.$request->surname;
//             $user->phone =$request->phone;
//             $user->country_code = $request->country_code;
//             $user->email = $request->email;
//             $user->user_type = "seller";
//             $user->email_verified_at = now();
//             $user->password = Hash::make($request->password);
//             dd($user);
//             if($user->save()){
//                 $seller = new Seller;
//                 $seller->user_id = $user->id;
//                 if($seller->save()){
//                     $shop = new Shop;
//                     $shop->user_id = $user->id;
//                     $shop->name = $request->shop_name;
//                     $shop->meta_title = $request->shop_name;
//                     $shop->slug =SlugService::createSlug(Shop::class, 'slug', slugify($request->shop_name));
//                     $shop->save();
//                     // $user->id=encrypt($user->id);
//                     auth()->login($user, true);
//                     $tokenResult = $user->createToken('Personal Access Token');
//                     return $this->loginSuccess($tokenResult, $user);
//                 }
//             }

//             // return view('backend.sellers.seller_verification_form.index');

//         }else if($request->method() === 'GET'){
//             if(Auth::check()){
//                 return redirect()->route('admin');
//             }
//             if($request->has('referral_code')){
//                 Cookie::queue('referral_code', $request->referral_code, 43200);
//             }
//             //   dd("sdufyydsfkkkg");
//                return view('frontend.user_registration');
//         }
//         return back();
//     }



//     public function cart_login(Request $request)
//     {
//         $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
//         if($user != null){
//             if(Hash::check($request->password, $user->password)){
//                 if($request->has('remember')){
//                     auth()->login($user, true);
//                 }
//                 else{
//                     auth()->login($user, false);
//                 }
//             }
//             else {
//                 flash(translate('Invalid email or password!'))->warning();
//             }
//         }
//         return back();
//     }

//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         //$this->middleware('auth');
//     }

//     /**
//      * Show the admin dashboard.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function admin_dashboard()
//     {
//         return view('backend.dashboard');
//     }

//     /**
//      * Show the customer/seller dashboard.
//      *
//      * @return \Illuminate\Http\Response
//      */
//     public function dashboard()
//     {
//         if(Auth::user()->user_type == 'seller'){
//             return view('frontend.user.seller.dashboard');
//         }
//         else if(Auth::user()->user_type == 'admin'){
//             return $this->admin_dashboard();
//         }
//         // elseif(Auth::user()->user_type == 'customer'){
//         //     return view('frontend.user.customer.dashboard');
//         // }
//         else {
//             return $this->admin_dashboard();
//             // abort(404);
//         }
//     }

//     public function profile(Request $request)
//     {
//         if(Auth::user()->user_type == 'customer'){
//             $addresses=Auth::user()->addresses;
//             return view('frontend.user.customer.profile', compact('addresses'));
//         }
//         elseif(Auth::user()->user_type == 'seller'){
//             $addresses=Auth::user()->addresses;
//             return view('frontend.user.seller.profile', compact('addresses'));
//         }
//     }

//     public function customer_update_profile(Request $request)
//     {
//         if(env('DEMO_MODE') == 'On'){
//             flash(translate('Sorry! the action is not permitted in demo '))->error();
//             return back();
//         }

//         $user = Auth::user();
//         $user->name = $request->name;
//         $user->address = $request->address;
//         $user->country = $request->country;
//         $user->city = $request->city;
//         $user->postal_code = $request->postal_code;
//         $user->phone = $request->phone;

//         if($request->new_password != null && ($request->new_password == $request->confirm_password)){
//             $user->password = Hash::make($request->new_password);
//         }
//         $user->avatar_original = $request->photo;

//         if($user->save()){
//             flash(translate('Your Profile has been updated successfully!'))->success();
//             return back();
//         }

//         flash(translate('Sorry! Something went wrong.'))->error();
//         return back();
//     }


//     public function seller_update_profile(Request $request)
//     {
//         if(env('DEMO_MODE') == 'On'){
//             flash(translate('Sorry! the action is not permitted in demo '))->error();
//             return back();
//         }

//         $user = Auth::user();
//         $user->name = $request->name;
//         $user->address = $request->address;
//         $user->country = $request->country;
//         $user->city = $request->city;
//         $user->postal_code = $request->postal_code;
//         $user->phone = $request->phone;

//         if($request->new_password != null && ($request->new_password == $request->confirm_password)){
//             $user->password = Hash::make($request->new_password);
//         }
//         $user->avatar_original = $request->photo;

//         $seller = $user->seller;
//         $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
//         $seller->bank_payment_status = $request->bank_payment_status;
//         $seller->bank_name = $request->bank_name;
//         $seller->bank_acc_name = $request->bank_acc_name;
//         $seller->bank_acc_no = $request->bank_acc_no;
//         $seller->bank_routing_no = $request->bank_routing_no;

//         if($user->save() && $seller->save()){
//             flash(translate('Your Profile has been updated successfully!'))->success();
//             return back();
//         }

//         flash(translate('Sorry! Something went wrong.'))->error();
//         return back();
//     }

//     /**
//      * Show the application frontend home.
//      *
//      * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
//      */
//     public function index()
//     {
//         // return redirect('https://marketpro.vercel.app/');
//         // return view('frontend.index');
//         if(auth()->user() != null){
//             return $this->dashboard();
//         }
//         return redirect()->route('login');
//     }

//     public function home(){
//         return redirect(default_website());
//     }

//     public function single_product($slug){
//         return redirect(default_website().'product/'.$slug);
//     }

//     public function flash_deal_details($slug)
//     {
//         $flash_deal = FlashDeal::where('slug', $slug)->first();
//         if($flash_deal != null)
//             return view('frontend.flash_deal_details', compact('flash_deal'));
//         else {
//             abort(404);
//         }
//     }

//     public function load_featured_section(){
//         return view('frontend.partials.featured_products_section');
//     }

//     public function load_best_selling_section(){
//         return view('frontend.partials.best_selling_section');
//     }

//     public function load_home_categories_section(){
//         return view('frontend.partials.home_categories_section');
//     }

//     public function load_best_sellers_section(){
//         return view('frontend.partials.best_sellers_section');
//     }

//     public function trackOrder(Request $request)
//     {
//         if($request->has('order_code')){
//             $order = Order::where('code', $request->order_code)->first();
//             if($order != null){
//                 return view('frontend.track_order', compact('order'));
//             }
//         }
//         return view('frontend.track_order');
//     }

//     public function product(Request $request, $slug)
//     {
//         $detailedProduct  = Product::where('slug', $slug)->first();

//         if($detailedProduct!=null && $detailedProduct->published){
//             //updateCartSetup();
//             if($request->has('product_referral_code')){
//                 Cookie::queue('product_referral_code', $request->product_referral_code, 43200);
//                 Cookie::queue('referred_product_id', $detailedProduct->id, 43200);
//             }
//             if($detailedProduct->digital == 1){
//                 return view('frontend.digital_product_details', compact('detailedProduct'));
//             }
//             else {
//                 return view('frontend.product_details', compact('detailedProduct'));
//             }
//             // return view('frontend.product_details', compact('detailedProduct'));
//         }
//         abort(404);
//     }

//     public function element(Request $request, $slug)
//     {
//         $detailedProduct  = Element::where('slug', $slug)->first();

//         if($detailedProduct!=null && $detailedProduct->published){
//             //updateCartSetup();
//             if($request->has('product_referral_code')){
//                 Cookie::queue('product_referral_code', $request->product_referral_code, 43200);
//                 Cookie::queue('referred_product_id', $detailedProduct->id, 43200);
//             }
//             if($detailedProduct->digital == 1){
//                 return view('frontend.digital_product_details', compact('detailedProduct'));
//             }
//             else {
//                 return view('frontend.product_details', compact('detailedProduct'));
//             }
//             // return view('frontend.product_details', compact('detailedProduct'));
//         }
//         abort(404);
//     }
//     public function shop($slug)
//     {
//         $shop  = Shop::where('slug', $slug)->first();
//         if($shop!=null){
//             $seller = Seller::where('user_id', $shop->user_id)->first();
//             if ($seller->verification_status != 0){
//                 return view('frontend.seller_shop', compact('shop'));
//             }
//             else{
//                 return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
//             }
//         }
//         abort(404);
//     }

//     public function filter_shop($slug, $type)
//     {
//         $shop  = Shop::where('slug', $slug)->first();
//         if($shop!=null && $type != null){
//             return view('frontend.seller_shop', compact('shop', 'type'));
//         }
//         abort(404);
//     }

//     public function all_categories(Request $request)
//     {
//         $categories = Category::where('level', 0)->orderBy('name', 'asc')->get();
//         return view('frontend.all_category', compact('categories'));
//     }
//     public function all_brands(Request $request)
//     {
//         $categories = Category::all();
//         return view('frontend.all_brand', compact('categories'));
//     }

//     public function characteristics(Request $request, $id)
//     {
//         if ($request->method() === 'POST') {
//             $product = Product::where('id', $id)->firstOrFail();
//             $product->characteristicValues()->delete();
//             if ($request->get('attr')) {
//                 foreach ($request->get('attr') as $item) {

//                     $data = [
//                         'product_id' => $product->id,
//                         'parent_id' => $item['parent_id'],
//                         'attr_id' => $item['id'],
//                         'name' => $item['name'],
//                     ];

//                     if (isset($item['values'])) {
//                         $data['values'] = implode(' / ', $item['values']);
//                     }

//                     CharacteristicValues::create($data);
//                 }
//             }

//             flash(translate('Saved successfully'))->success();
//             return back();
//         } else {
//             $product = Product::where('id', $id)
//                 ->with(['characteristicValues'])
//                 ->firstOrFail();
//             $options = $product->category->productAttributes;

//             return view('frontend.user.seller.add_attr', compact(
//                 'product', 'options'
//             ));
//         }
//     }

//     public function show_product_clone_form(Request $request)
//     {
//         if($request->method() == 'POST') {
//             if($request->has('product_ids')){
//                 $request->validate([
//                     'product_ids' => 'required'
//                 ]);
//                 foreach ($product_ids=$request->product_ids as $product_id) {
//                     $product = Product::find($product_id);
//                     $product_translations = $product->product_translations;
//                     $characteristics = CharacteristicValues::where('product_id', $product->id)->get();
//                     $product_new = $product->replicate();
//                     $product_new->slug = substr($product_new->slug, 0, -5).Str::random(5);
//                     $product_new->user_id = Auth::user()->id;
//                     $product_new->added_by = 'seller';
//                     $product_new->on_moderation = 1;
//                     $product_new->is_accepted = 0;
//                     if($product_new->save()){
//                         foreach ($product_translations as $translation) {
//                             ProductTranslation::create([
//                                 'product_id' => $product_new->id,
//                                 'name' => $translation->name,
//                                 'lang' => $translation->lang
//                             ]);
//                         }
//                         foreach ($characteristics as $characteristic) {
//                             CharacteristicValues::create([
//                                 'parent_id' => $characteristic->parent_id,
//                                 'product_id' => $product_new->id,
//                                 'attr_id' => $characteristic->attr_id,
//                                 'name' => $characteristic->name,
//                                 'values' => $characteristic->values
//                             ]);
//                         }
//                     }
//                 }
//                 flash(translate('All done'))->success();
//                 return back();
//             }else{
//                 $request->validate([
//                     'product_id' => 'required'
//                 ]);
//                 $product = Product::find($request->get('product_id'));
//                 $product_translations = $product->product_translations;
//                 $characteristics = CharacteristicValues::where('product_id', $product->id)->get();
//                 $product_new = $product->replicate();
//                 $product_new->slug = substr($product_new->slug, 0, -5).Str::random(5);
//                 $product_new->user_id = Auth::user()->id;
//                 $product_new->added_by = 'seller';
//                 $product_new->on_moderation = 1;
//                 $product_new->is_accepted = 0;

//                 if($product_new->save()){
//                     foreach ($product_translations as $translation) {
//                         ProductTranslation::create([
//                             'product_id' => $product_new->id,
//                             'name' => $translation->name,
//                             'lang' => $translation->lang
//                         ]);
//                     }
//                     foreach ($characteristics as $characteristic) {
//                         CharacteristicValues::create([
//                             'parent_id' => $characteristic->parent_id,
//                             'product_id' => $product_new->id,
//                             'attr_id' => $characteristic->attr_id,
//                             'name' => $characteristic->name,
//                             'values' => $characteristic->values
//                         ]);
//                     }
//                     return redirect()->route('seller.products.edit', [$product_new->id, 'lang' => 'en']);
//                 }
//                 else{
//                     flash(translate('Something went wrong'))->error();
//                     return back();
//                 }
//             }

//         }
//         // dd("ok");
//         $products = Product::where('digital', 0)->orderBy('created_at', 'desc')->get();
//         // dd($products);
//         return view('frontend.user.seller.product_clone_new', compact('products'));
//         // $this->clone_from_all_product_list();
//         // return view('frontend.user.seller.product_clone');
//     }

//     public function show_product_upload_form(Request $request)
//     {
//         if(\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated){
//      //       if(Auth::user()->seller->remaining_uploads > 0){
//         $categories = Category::where('parent_id', null)
//             ->where('digital', 0)
//             ->with('childrenCategories')
//             ->get();
//                 return view('frontend.user.seller.product_upload', compact('categories'));
//      //       }
//      //       else {
//      //           flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
//      //           return back();
//      //       }
//         }
//         $categories = Category::where('parent_id', null)
//             ->where('digital', 0)
//             ->with('childrenCategories')
//             ->get();
//         return view('frontend.user.seller.product_upload', compact('categories'));
//     }

//     public function show_product_edit_form(Request $request, $id)
//     {
//         $product = Product::findOrFail($id);
//         $lang = $request->lang;
//         $tags = json_decode($product->tags);
//         $categories = Category::all()->toTree();
//         return view('frontend.user.seller.product_edit', compact('product', 'categories', 'tags', 'lang'));
//     }

//     public function seller_product_list(Request $request)
//     {
//         $search = null;
//         $products = Product::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
//         if ($request->has('search')) {
//             $search = $request->search;
//             $products = $products->where('name', 'like', '%'.$search.'%');
//         }
//         $products = $products->paginate(10);
//         return view('frontend.user.seller.products', compact('products', 'search'));
//     }

//     public function clone_from_all_product_list()
//     {
//         $products = Product::where('digital', 0)->orderBy('created_at', 'desc');
//         return view('frontend.user.seller.product_clone', compact('products'));
//     }

//     public function ajax_search(Request $request)
//     {
//         $keywords = array();
//         $products = Product::where('published', 1)->where('tags', 'like', '%'.$request->search.'%')->get();
//         foreach ($products as $key => $product) {
//             foreach (explode(',',$product->tags) as $key => $tag) {
//                 if(stripos($tag, $request->search) !== false){
//                     if(sizeof($keywords) > 5){
//                         break;
//                     }
//                     else{
//                         if(!in_array(strtolower($tag), $keywords)){
//                             array_push($keywords, strtolower($tag));
//                         }
//                     }
//                 }
//             }
//         }

//         $products = filter_products(Product::where('published', 1)->where('name', 'like', '%'.$request->search.'%'))->get()->take(3);

//         $categories = Category::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

//         $shops = Shop::whereIn('user_id', verified_sellers_id())->where('name', 'like', '%'.$request->search.'%')->get()->take(3);

//         if(sizeof($keywords)>0 || sizeof($categories)>0 || sizeof($products)>0 || sizeof($shops) >0){
//             return view('frontend.partials.search_content', compact('products', 'categories', 'keywords', 'shops'));
//         }
//         return '0';
//     }

//     public function listing(Request $request)
//     {
//         return $this->search($request);
//     }

//     public function listingByCategory(Request $request, $category_slug)
//     {
//         $category = Category::where('slug', $category_slug)->first();

//         if ($category != null) {
//             return $this->search($request, $category->id);
//         }

//         abort(404);
//     }

//     public function listingByBrand(Request $request, $brand_slug)
//     {
//         $brand = Brand::where('slug', $brand_slug)->first();
//         if ($brand != null) {
//             return $this->search($request, null, $brand->id);
//         }
//         abort(404);
//     }

//     public function search(Request $request, $category_id = null, $brand_id = null)
//     {
//         $query = $request->q;
//         $sort_by = $request->sort_by;
//         $min_price = $request->min_price;
//         $max_price = $request->max_price;
//         $seller_id = $request->seller_id;

//         $conditions = ['published' => 1];

//         if($brand_id != null){
//             $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
//         }elseif ($request->brand != null) {
//             $brand_id = (Brand::where('slug', $request->brand)->first() != null) ? Brand::where('slug', $request->brand)->first()->id : null;
//             $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
//         }

//         if($seller_id != null){
//             $conditions = array_merge($conditions, ['user_id' => Seller::findOrFail($seller_id)->user->id]);
//         }

//         $products = Product::where($conditions);

//         if($category_id != null){
//             $category_ids = CategoryUtility::children_ids($category_id);
//             $category_ids[] = $category_id;

//             $products = $products->whereIn('category_id', $category_ids);
//         }

//         if($min_price != null && $max_price != null){
//             $products = $products->where('unit_price', '>=', $min_price)->where('unit_price', '<=', $max_price);
//         }

//         if($query != null){
//             $searchController = new SearchController;
//             $searchController->store($request);
//             $products = $products->where('name', 'like', '%'.$query.'%')->orWhere('tags', 'like', '%'.$query.'%');
//         }

//         if($sort_by != null){
//             switch ($sort_by) {
//                 case 'newest':
//                     $products->orderBy('created_at', 'desc');
//                     break;
//                 case 'oldest':
//                     $products->orderBy('created_at', 'asc');
//                     break;
//                 case 'price-asc':
//                     $products->orderBy('unit_price', 'asc');
//                     break;
//                 case 'price-desc':
//                     $products->orderBy('unit_price', 'desc');
//                     break;
//                 default:
//                     // code...
//                     break;
//             }
//         }


//         $non_paginate_products = filter_products($products)->get();

//         //Attribute Filter

//         $attributes = array();
//         foreach ($non_paginate_products as $key => $product) {
//             if($product->attributes != null && is_array(json_decode($product->attributes))){
//                 foreach (json_decode($product->attributes) as $key => $value) {
//                     $flag = false;
//                     $pos = 0;
//                     foreach ($attributes as $key => $attribute) {
//                         if($attribute['id'] == $value){
//                             $flag = true;
//                             $pos = $key;
//                             break;
//                         }
//                     }
//                     if(!$flag){
//                         $item['id'] = $value;
//                         $item['values'] = array();
//                         foreach (json_decode($product->choice_options) as $key => $choice_option) {
//                             if($choice_option->attribute_id == $value){
//                                 $item['values'] = $choice_option->values;
//                                 break;
//                             }
//                         }
//                         array_push($attributes, $item);
//                     }
//                     else {
//                         foreach (json_decode($product->choice_options) as $key => $choice_option) {
//                             if($choice_option->attribute_id == $value){
//                                 foreach ($choice_option->values as $key => $value) {
//                                     if(!in_array($value, $attributes[$pos]['values'])){
//                                         array_push($attributes[$pos]['values'], $value);
//                                     }
//                                 }
//                             }
//                         }
//                     }
//                 }
//             }
//         }

//         $selected_attributes = array();

//         foreach ($attributes as $key => $attribute) {
//             if($request->has('attribute_'.$attribute['id'])){
//                 foreach ($request['attribute_'.$attribute['id']] as $key => $value) {
//                     $str = '"'.$value.'"';
//                     $products = $products->where('choice_options', 'like', '%'.$str.'%');
//                 }

//                 $item['id'] = $attribute['id'];
//                 $item['values'] = $request['attribute_'.$attribute['id']];
//                 array_push($selected_attributes, $item);
//             }
//         }


//         //Color Filter
//         $all_colors = array();

//         foreach ($non_paginate_products as $key => $product) {
//             if ($product->colors != null) {
//                 foreach (json_decode($product->colors) as $key => $color) {
//                     if(!in_array($color, $all_colors)){
//                         array_push($all_colors, $color);
//                     }
//                 }
//             }
//         }

//         $selected_color = null;

//         if($request->has('color')){
//             $str = '"'.$request->color.'"';
//             $products = $products->where('colors', 'like', '%'.$str.'%');
//             $selected_color = $request->color;
//         }


//         $products = filter_products($products)->paginate(12)->appends(request()->query());

//         return view('frontend.product_listing', compact('products', 'query', 'category_id', 'brand_id', 'sort_by', 'seller_id','min_price', 'max_price', 'attributes', 'selected_attributes', 'all_colors', 'selected_color'));
//     }

//     public function home_settings(Request $request)
//     {
//         return view('home_settings.index');
//     }

//     public function top_10_settings(Request $request)
//     {
//         foreach (Category::all() as $key => $category) {
//             if(is_array($request->top_categories) && in_array($category->id, $request->top_categories)){
//                 $category->top = 1;
//                 $category->save();
//             }
//             else{
//                 $category->top = 0;
//                 $category->save();
//             }
//         }

//         foreach (Brand::all() as $key => $brand) {
//             if(is_array($request->top_brands) && in_array($brand->id, $request->top_brands)){
//                 $brand->top = 1;
//                 $brand->save();
//             }
//             else{
//                 $brand->top = 0;
//                 $brand->save();
//             }
//         }

//         flash(translate('Top 10 categories and brands have been updated successfully'))->success();
//         return redirect()->route('home_settings.index');
//     }

//     public function variant_price(Request $request)
//     {
//         $product = Product::find($request->id);
//         $str = '';
//         $quantity = 0;

//         if($request->has('color')){
//             $data['color'] = $request['color'];
//             $str = Color::where('code', $request['color'])->first()->name;
//         }

//         if(json_decode(Product::find($request->id)->choice_options) != null){
//             foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
//                 if($str != null){
//                     $str .= '-'.str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
//                 }
//                 else{
//                     $str .= str_replace(' ', '', $request['attribute_id_'.$choice->attribute_id]);
//                 }
//             }
//         }



//         if($str != null && $product->variant_product){
//             $product_stock = $product->stocks->where('variant', $str)->first();
//             $price = $product_stock->price;
//             $quantity = $product_stock->qty;
//         }
//         else{
//             $price = $product->unit_price;
//             $quantity = $product->current_stock;
//         }

//         //discount calculation
//         $flash_deals = \App\FlashDeal::where('status', 1)->get();
//         $inFlashDeal = false;
//         foreach ($flash_deals as $key => $flash_deal) {
//             if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
//                 $flash_deal_product = \App\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
//                 if($flash_deal_product->discount_type == 'percent'){
//                     $price -= ($price*$flash_deal_product->discount)/100;
//                 }
//                 elseif($flash_deal_product->discount_type == 'amount'){
//                     $price -= $flash_deal_product->discount;
//                 }
//                 $inFlashDeal = true;
//                 break;
//             }
//         }
//         if (!$inFlashDeal) {
//             if($product->discount_type == 'percent'){
//                 $price -= ($price*$product->discount)/100;
//             }
//             elseif($product->discount_type == 'amount'){
//                 $price -= $product->discount;
//             }
//         }

//         if($product->tax_type == 'percent'){
//             $price += ($price*$product->tax)/100;
//         }
//         elseif($product->tax_type == 'amount'){
//             $price += $product->tax;
//         }
//         return array('price' => single_price($price*$request->quantity), 'quantity' => $quantity, 'digital' => $product->digital);
//     }

//     public function sellerpolicy(){
//         return view("frontend.policies.sellerpolicy");
//     }

//     public function returnpolicy(){
//         return view("frontend.policies.returnpolicy");
//     }

//     public function supportpolicy(){
//         return view("frontend.policies.supportpolicy");
//     }

//     public function terms(){
//         return view("frontend.policies.terms");
//     }

//     public function privacypolicy(){
//         return view("frontend.policies.privacypolicy");
//     }

//     public function get_pick_ip_points(Request $request)
//     {
//         $pick_up_points = PickupPoint::all();
//         return view('frontend.partials.pick_up_points', compact('pick_up_points'));
//     }

//     public function get_category_items(Request $request){
//         $category = Category::findOrFail($request->id);
//         return view('frontend.partials.category_elements', compact('category'));
//     }

//     public function premium_package_index()
//     {
//         $customer_packages = CustomerPackage::all();
//         return view('frontend.user.customer_packages_lists', compact('customer_packages'));
//     }

//     public function seller_digital_product_list(Request $request)
//     {
//         $products = Product::where('user_id', Auth::user()->id)->where('digital', 1)->orderBy('created_at', 'desc')->paginate(10);
//         return view('frontend.user.seller.digitalproducts.products', compact('products'));
//     }
//     public function show_digital_product_upload_form(Request $request)
//     {
//         if(\App\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Addon::where('unique_identifier', 'seller_subscription')->first()->activated){
// //            if(Auth::user()->seller->remaining_digital_uploads > 0){
//                 $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
//                 $categories = Category::where('digital', 1)->get();
//                 return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
// //            }
// //            else {
// //                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
// //                return back();
// //            }
//         }

//         $business_settings = BusinessSetting::where('type', 'digital_product_upload')->first();
//         $categories = Category::where('digital', 1)->get();
//         return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
//     }

//     public function show_digital_product_edit_form(Request $request, $id)
//     {
//         $categories = Category::where('digital', 1)->get();
//         $lang = $request->lang;
//         $product = Product::find($id);
//         return view('frontend.user.seller.digitalproducts.product_edit', compact('categories', 'product', 'lang'));
//     }

//     // Ajax call
//     public function new_verify(Request $request)
//     {
//         $email = $request->email;
//         if(isUnique($email) == '0') {
//             $response['status'] = 2;
//             $response['message'] = 'Email already exists!';
//             return json_encode($response);
//         }

//         $response = $this->send_email_change_verification_mail($request, $email);
//         return json_encode($response);
//     }


//     // Form request
//     public function update_email(Request $request)
//     {
//         $email = $request->email;
//         if(isUnique($email)) {
//             $this->send_email_change_verification_mail($request, $email);
//             flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
//             return back();
//         }

//         flash(translate('Email already exists!'))->warning();
//         return back();
//     }

//     public function send_email_change_verification_mail($request, $email)
//     {
//         $response['status'] = 0;
//         $response['message'] = 'Unknown';

//         $verification_code = Str::random(32);

//         $array['subject'] = 'Email Verification';
//         $array['from'] = env('MAIL_USERNAME');
//         $array['content'] = 'Verify your account';
//         $array['link'] = route('email_change.callback').'?new_email_verificiation_code='.$verification_code.'&email='.$email;
//         $array['sender'] = Auth::user()->name;
//         $array['details'] = "Email Second";

//         $user = Auth::user();
//         $user->new_email_verificiation_code = $verification_code;
//         $user->save();

//         try {
//             Mail::to($email)->queue(new SecondEmailVerifyMailManager($array));

//             $response['status'] = 1;
//             $response['message'] = translate("Your verification mail has been Sent to your email.");

//         } catch (\Exception $e) {
//             // return $e->getMessage();
//             $response['status'] = 0;
//             $response['message'] = $e->getMessage();
//         }

//         return $response;
//     }

//     public function email_change_callback(Request $request){
//         if($request->has('new_email_verificiation_code') && $request->has('email')) {
//             $verification_code_of_url_param =  $request->input('new_email_verificiation_code');
//             $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

//             if($user != null) {

//                 $user->email = $request->input('email');
//                 $user->new_email_verificiation_code = null;
//                 $user->save();

//                 auth()->login($user, true);

//                 flash(translate('Email Changed successfully'))->success();
//                 return redirect()->route('dashboard');
//             }
//         }

//         flash(translate('Email was not verified. Please resend your mail!'))->error();
//         return redirect()->route('dashboard');

//     }

//     public function reset_password_with_code(Request $request){
//         if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
//             if($request->password == $request->password_confirmation){
//                 $user->password = Hash::make($request->password);
//                 $user->email_verified_at = date('Y-m-d h:m:s');
//                 $user->save();
//                 event(new PasswordReset($user));
//                 auth()->login($user, true);

//                 flash(translate('Password updated successfully'))->success();

//                 if(auth()->user()->user_type == 'admin' || auth()->user()->user_type == 'staff')
//                 {
//                     return redirect()->route('admin.dashboard');
//                 }
//                 return redirect()->route('login');
//             }
//             else {
//                 flash("Password and confirm password didn't match")->warning();
//                 return back();
//             }
//         }
//         else {
//             flash("Verification code mismatch")->error();
//             return back();
//         }
//     }
// }
// <<<<<<< HEAD
// // >>>>>>> 98a8917772775c0ac3ee81e4ef2add480a32007d
// =======
// >>>>>>> d151758a2c8539205eb92863303565315be47a58
