<?php

use App\Address;
use App\Attribute;
use App\Currency;
use App\BusinessSetting;
use App\Category;
use App\Characteristic;
use App\Http\HelperClasses\Colorcodeconverter;
use App\Http\HelperClasses\Timezones;
use App\Product;
use App\SubSubCategory;
use App\FlashDealProduct;
use App\FlashDeal;
use App\OtpConfiguration;
use App\Upload;
use App\Translation;
use App\City;
use App\Delivery;
use App\Element;
use App\IpAddress;
use App\Language;
use App\Utility\TranslationUtility;
use App\Utility\CategoryUtility;
use App\Utility\MimoUtility;
use Twilio\Rest\Client;
use App\Utility\sms\EskizSmsClient;
use App\Notifications\EmailVerificationNotification;
use App\SellerSetting;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

//highlights the selected navigation on admin panel
if (!function_exists('sendSMS')) {
    function sendSMS($to, $from, $text)
    {
        if (OtpConfiguration::where('type', 'nexmo')->first()->value == 1) {
            try {
                $my_sms = new EskizSmsClient;
                $response = $my_sms->send($to, $from . " " . $text);
            } catch (\Exception $e) {
                //dd($e->getMessage());
                // throw $th;
            }
            // $api_key = env("NEXMO_KEY"); //put ssl provided api_token here
            // $api_secret = env("NEXMO_SECRET"); // put ssl provided sid here

            // $params = [
            //     "api_key" => $api_key,
            //     "api_secret" => $api_secret,
            //     "from" => $from,
            //     "text" => $text,
            //     "to" => $to
            // ];

            // $url = "https://rest.nexmo.com/sms/json";
            // $params = json_encode($params);

            // $ch = curl_init(); // Initialize cURL
            // curl_setopt($ch, CURLOPT_URL, $url);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            // curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            //     'Content-Type: application/json',
            //     'Content-Length: ' . strlen($params),
            //     'accept:application/json'
            // ));
            // $response = curl_exec($ch);
            // curl_close($ch);

            return $response;
        } elseif (OtpConfiguration::where('type', 'twillo')->first()->value == 1) {
            $sid = env("TWILIO_SID"); // Your Account SID from www.twilio.com/console
            $token = env("TWILIO_AUTH_TOKEN"); // Your Auth Token from www.twilio.com/console

            $client = new Client($sid, $token);
            try {
                $message = $client->messages->create(
                    $to, // Text this number
                    array(
                        'from' => env('VALID_TWILLO_NUMBER'), // From a valid Twilio number
                        'body' => $text
                    )
                );
            } catch (\Exception $e) {
            }
        } elseif (OtpConfiguration::where('type', 'ssl_wireless')->first()->value == 1) {
            $token = env("SSL_SMS_API_TOKEN"); //put ssl provided api_token here
            $sid = env("SSL_SMS_SID"); // put ssl provided sid here

            $params = [
                "api_token" => $token,
                "sid" => $sid,
                "msisdn" => $to,
                "sms" => $text,
                "csms_id" => date('dmYhhmi') . rand(10000, 99999)
            ];

            $url = env("SSL_SMS_URL");
            $params = json_encode($params);

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($params),
                'accept:application/json'
            ));

            $response = curl_exec($ch);

            curl_close($ch);

            return $response;
        } elseif (OtpConfiguration::where('type', 'fast2sms')->first()->value == 1) {

            if (strpos($to, '+91') !== false) {
                $to = substr($to, 3);
            }

            $fields = array(
                "sender_id" => env("SENDER_ID"),
                "message" => $text,
                "language" => env("LANGUAGE"),
                "route" => env("ROUTE"),
                "numbers" => $to,
            );

            $auth_key = env('AUTH_KEY');

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($fields),
                CURLOPT_HTTPHEADER => array(
                    "authorization: $auth_key",
                    "accept: */*",
                    "cache-control: no-cache",
                    "content-type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            return $response;
        } elseif (OtpConfiguration::where('type', 'mimo')->first()->value == 1) {
            $token = MimoUtility::getToken();

            MimoUtility::sendMessage($text, $to, $token);
            MimoUtility::logout($token);
        }
    }
}

//highlights the selected navigation on admin panel
if (!function_exists('areActiveRoutes')) {
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
    }
}

//highlights the selected navigation on frontend
if (!function_exists('default_language')) {
    function default_language()
    {
        return env("DEFAULT_LANGUAGE", 'ru');
    }
}

//highlights the selected navigation on frontend
if (!function_exists('defaultLanguage')) {
    function defaultLanguage()
    {
        return env("DEFAULT_LANGUAGE", 'ru');
    }
}

if (!function_exists('default_website')) {
    function default_website()
    {
        return "http://tinfis.vercel.app/";
    }
}

/**
 * Save JSON File
 * @return Response
 */
if (!function_exists('convert_to_usd')) {
    function convert_to_usd($amount)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::find($business_settings->value);
            return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'USD')->first()->exchange_rate;
        }
    }
}

if (!function_exists('convert_to_kes')) {
    function convert_to_kes($amount)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::find($business_settings->value);
            return (floatval($amount) / floatval($currency->exchange_rate)) * Currency::where('code', 'KES')->first()->exchange_rate;
        }
    }
}

//filter products based on vendor activation system
if (!function_exists('filter_products')) {
    function filter_products($products)
    {
        $verified_sellers = verified_sellers_id();
        if (BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1) {
            return $products->where('published', '1')->orderBy('created_at', 'desc')->where(function ($p) use ($verified_sellers) {
                $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
                    $q->whereIn('user_id', $verified_sellers);
                });
            });
        } else {
            return $products->where('published', '1')->where('added_by', 'admin');
        }
    }
}

if (!function_exists('slugify')) {
    function slugify($string)
    {
        // $string = preg_replace('/\s+/', '-', $string);
        $string = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $string);
        return $string;
    }
}
if (!function_exists('getProductCategories')) {
    function getProductCategories($items, $level=2, $type='product')
    {
        if($type=='element'){
            $element_ids=$items->pluck('element_id');
        }else{
            //Type product and variation by default
            $element_ids=$items->select('element_id')->distinct()->pluck('element_id');
        }
        $sub_sub_category_ids=Element::whereIn('id', $element_ids)->pluck('category_id');
        $sub_sub_categories=Category::whereIn('id', $sub_sub_category_ids);
        if($level==2){
            return $sub_sub_categories;
        }
        $sub_category_ids=$sub_sub_categories->pluck('parent_id');
        $sub_categories=Category::whereIn('id', $sub_category_ids);
        if($level==1){
            return $sub_categories;
        }
        $category_ids=$sub_categories->pluck('parent_id');
        $categories=Category::whereIn('id', $category_ids);
        return $categories;
    }
}

if (!function_exists('searchItemByTranslation')) {
    function searchItemByTranslation($table, $search_text=null, $search_field=null, $item_ids=[],  $lang=null)
    {
        $results=DB::table($table.'_translations');
        if($search_field){
            $results=$results->where($search_field, 'like', '%'.$search_text.'%');
        }

        if(count($item_ids)>0){
            $results=$results->whereIn($table.'_id', $item_ids);
        }

        if($lang){
            $results=$results->where('lang',$lang);
        }

        return $results->pluck($table.'_id');
    }
}
if (!function_exists('filterPublishedProducts')) {
    function filterPublishedProducts($products)
    {
        $published_condition=[['qty', '>', 0], ['is_accepted', 1], ['published', 1], ['variation_id', '<>', null], ['element_id', '<>', null], ['deleted_at', '=', null]];
        $element_conditions['where'][] = ['is_accepted', 1];
        $element_conditions['where'][] = ['published', 1];
        $products = $products->where($published_condition);
        $products = filterProductByRelation($products, 'element', $element_conditions);
        return $products;
    }
}
if (!function_exists('hasSuchAttribute')) {
    function hasSuchAttribute($product, $attribute_id)
    {
        if(isset($attribute_id) && isset($product->variation->characteristics)){
            $attribute_ids=explode(',', $product->variation->characteristics);
            if(in_array($attribute_id, $attribute_ids)){
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('getPublishedProducts')) {
    function getPublishedProducts($type = 'product', $product_conditions = [], $variation_conditions = [], $element_conditions = [], $is_random=true)
    {
        $products = filterPublishedProducts(Product::where('deleted_at', '=', null));
        $products = filterProductByRelation($products, 'product', $product_conditions);
        $products = filterProductByRelation($products, 'variation', $variation_conditions);
        $products = filterProductByRelation($products, 'element', $element_conditions);
        if ($type == 'product') {
            return $products;
        }
        $products = groupByDistinctRelation($products, 'variation_id', $is_random);
        if ($type == 'variation') {
            return $products;
        }
        // $element_id_list=removeDuplicatesFromElement($products->groupBy('element_id')->pluck('element_id')->toArray());
        $products = groupByDistinctRelation($products, 'element_id', $is_random);
        if ($type == 'element') {
            return $products;
        }
        return $products;
    }
}
if (!function_exists('groupByDistinctRelation')) {
    function groupByDistinctRelation($products, $relation_column='element_id', $is_random=true){
        $relation_ids = [];
        $relations = $products->get()->groupBy($relation_column);
        if($is_random){
            foreach ($relations as $relation_id => $models) {
                $relation_ids[] = $models->random()->id;
            }
        }else{
            foreach ($relations as $relation_id => $models) {
                $relation_ids[] = $models->first()->id;
            }
        }

        $products = $products->whereIn('id', $relation_ids);
        return $products;
    }
}
if (!function_exists('filterProductByRelation')) {
    function filterProductByRelation($products, $relation_name, $conditions)
    {
        if (count($conditions) > 0) {
            if ($relation_name == 'product') {
                if (array_key_exists('where', $conditions)) {
                    $products->where($conditions['where']);
                    // foreach($conditions['where'] as $condition){
                    //     $products->where($condition);
                    // }
                }
                if (array_key_exists('whereIn', $conditions)) {
                    foreach($conditions['whereIn'] as $condition){
                        foreach($condition as $column=>$items){
                            $products->whereIn($column, $items);
                        }
                    }
                }
                if (array_key_exists('orderBy', $conditions)) {
                    foreach($conditions['orderBy'] as $condition){
                        foreach($condition as $column=>$direction){
                            $products->orderBy($column, $direction);
                        }
                    }
                }
                if (array_key_exists('random', $conditions)) {
                    $products->inRandomOrder();
                }
                return $products;
            }
            $products = $products->whereHas($relation_name, function ($relation) use ($conditions) {
                if (array_key_exists('where', $conditions)) {
                    $relation->where($conditions['where']);
                }
                if (array_key_exists('whereIn', $conditions)) {
                    foreach($conditions['whereIn'] as $condition){
                        foreach($condition as $column=>$items){
                            $relation->whereIn($column, $items);
                        }
                    }
                }
                if (array_key_exists('orderBy', $conditions)) {
                    foreach($conditions['orderBy'] as $condition){
                        foreach($condition as $column=>$direction){
                            $relation->orderBy($column, $direction);
                        }
                    }
                }
                if (array_key_exists('random', $conditions)) {
                    $relation->inRandomOrder();
                }
            });
            // dd($products->get());
            return $products;
        }
        return $products;
    }
}
//cache products based on category
if (!function_exists('get_cached_products')) {
    function get_cached_products($category_id = null)
    {
        $products = \App\Product::where('published', 1);
        $verified_sellers = verified_sellers_id();
        if (BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1) {
            $products = $products->where(function ($p) use ($verified_sellers) {
                $p->where('added_by', 'admin')->orWhere(function ($q) use ($verified_sellers) {
                    $q->whereIn('user_id', $verified_sellers);
                });
            });
        } else {
            $products = $products->where('added_by', 'admin');
        }

        if ($category_id != null) {
            return Cache::remember('products-category-' . $category_id, 86400, function () use ($category_id, $products) {
                $category_ids = CategoryUtility::children_ids($category_id);
                $category_ids[] = $category_id;
                return $products->whereIn('category_id', $category_ids)->latest()->take(12)->get();
            });
        } else {
            return Cache::remember('products', 86400, function () use ($products) {
                return $products->latest()->get();
            });
        }
    }
}

if (!function_exists('verified_sellers_id')) {
    function verified_sellers_id()
    {
        return App\Seller::where('verification_status', 1)->get()->pluck('user_id')->toArray();
    }
}

//converts currency to home default currency
if (!function_exists('convert_price')) {
    function convert_price($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::find($business_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }

        $code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }

        $price = floatval($price) * floatval($currency->exchange_rate);

        return $price;
    }
}

//formats currency
if (!function_exists('format_price')) {
    function format_price($price)
    {
        if (BusinessSetting::where('type', 'decimal_separator')->first()->value == 1) {
            $fomated_price = number_format($price, BusinessSetting::where('type', 'no_of_decimals')->first()->value);
        } else {
            $fomated_price = number_format($price, BusinessSetting::where('type', 'no_of_decimals')->first()->value, ',', ' ');
        }

        if (BusinessSetting::where('type', 'symbol_format')->first()->value == 1) {
            return currency_symbol() . $fomated_price;
        }
        return $fomated_price . currency_symbol();
    }
}

//formats price to home default price with convertion
if (!function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

//Shows Price on page based on low to high
if (!function_exists('home_price')) {
    function home_price($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->price;
        $highest_price = $product->price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if ($lowest_price == $highest_price) {
            return format_price($lowest_price);
        } else {
            return format_price($lowest_price) . ' - ' . format_price($highest_price);
        }
    }
}

//Shows Price on page based on low to high with discount
if (!function_exists('home_discounted_price')) {
    function home_discounted_price($id)
    {
        return 0;
        $product = Product::findOrFail($id);
        $lowest_price = $product->price;
        $highest_price = $product->price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $flash_deals = \App\FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                    $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }

        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if ($lowest_price == $highest_price) {
            return format_price($lowest_price);
        } else {
            return format_price($lowest_price) . ' - ' . format_price($highest_price);
        }
    }
}

//Shows Base Price
if (!function_exists('home_base_price')) {
    function home_base_price($id)
    {
        return 0;
        if ($product = Product::findOrFail($id)) {
            $price = $product->price;
            if ($product->tax_type == 'percent') {
                $price += ($price * $product->tax) / 100;
            } elseif ($product->tax_type == 'amount') {
                $price += $product->tax;
            }
            return format_price(convert_price($price));
        }
        return 0;
    }
}

//Shows Base Price with discount
if (!function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($id)
    {
        return 0;
        if ($product = Product::findOrFail($id)) {
            $price = $product->price;

            $flash_deals = \App\FlashDeal::where('status', 1)->get();
            $inFlashDeal = false;
            foreach ($flash_deals as $flash_deal) {
                if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                    $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
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

            return format_price(convert_price($price));
        }
        return 0;
    }
}

if (!function_exists('currency_symbol')) {
    function currency_symbol()
    {
        $code = \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }
        return $currency->symbol;
    }
}

if (!function_exists('renderStarRating')) {
    function renderStarRating($rating, $maxRating = 5)
    {
        $fullStar = "<i class = 'las la-star active'></i>";
        $halfStar = "<i class = 'las la-star half'></i>";
        $emptyStar = "<i class = 'las la-star'></i>";
        $rating = $rating <= $maxRating ? $rating : $maxRating;

        $fullStarCount = (int)$rating;
        $halfStarCount = ceil($rating) - $fullStarCount;
        $emptyStarCount = $maxRating - $fullStarCount - $halfStarCount;

        $html = str_repeat($fullStar, $fullStarCount);
        $html .= str_repeat($halfStar, $halfStarCount);
        $html .= str_repeat($emptyStar, $emptyStarCount);
        echo $html;
    }
}


//Api
if (!function_exists('homeBasePrice')) {
    function homeBasePrice($id)
    {
        // return 0;
        $product = Product::findOrFail($id);
        $currency = $product->currency;
        $price = $product->price;
        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }
        return convertCurrency($price, $currency->id);
    }
}

if (!function_exists('homeDiscountedBasePrice')) {
    function homeDiscountedBasePrice($id)
    {
        // return 0;
        $product = Product::findOrFail($id);
        $currency = $product->currency;
        $price = $product->price;

        $flash_deals = FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
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
        return convertCurrency($price, $currency->id);
    }
}

if (!function_exists('homePrice')) {
    function homePrice($id)
    {
        return 0;
        $product = Product::findOrFail($id);
        $lowest_price = $product->price;
        $highest_price = $product->price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convertPrice($lowest_price);
        $highest_price = convertPrice($highest_price);

        return $lowest_price . ' - ' . $highest_price;
    }
}

if (!function_exists('homeDiscountedPrice')) {
    function homeDiscountedPrice($id)
    {
        return 0;
        $product = Product::findOrFail($id);
        $lowest_price = $product->price;
        $highest_price = $product->price;

        if ($product->variant_product) {
            foreach ($product->stocks as $key => $stock) {
                if ($lowest_price > $stock->price) {
                    $lowest_price = $stock->price;
                }
                if ($highest_price < $stock->price) {
                    $highest_price = $stock->price;
                }
            }
        }

        $flash_deals = FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
                $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $lowest_price -= ($lowest_price * $flash_deal_product->discount) / 100;
                    $highest_price -= ($highest_price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }

        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $lowest_price -= ($lowest_price * $product->discount) / 100;
                $highest_price -= ($highest_price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $lowest_price += ($lowest_price * $product->tax) / 100;
            $highest_price += ($highest_price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convertPrice($lowest_price);
        $highest_price = convertPrice($highest_price);

        return $lowest_price . ' - ' . $highest_price;
    }
}

if (!function_exists('brandsOfCategory')) {
    function brandsOfCategory($category_id)
    {
        $brands = [];
        if($category=Category::where('id', $category_id)->first()){
            $brands=$category->brands()->get();
        }
        // $category_brands=Element::where('category_id', $category_id)->select('brand_id')->get();
        // dd(Category::decendantsAndSelf())
        // dd($category_brands->toArray());
        // $subCategories = Category::where('parent_id', $category_id)->get();
        // foreach ($subCategories as $subCategory) {
        //     $subSubCategories = Category::where('parent_id', $subCategory->id)->get();
        //     foreach ($subSubCategories as $subSubCategory) {
        //         $brand = json_decode($subSubCategory->brands);
        //         foreach ($brand as $b) {
        //             if (in_array($b, $brands)) continue;
        //             array_push($brands, $b);
        //         }
        //     }
        // }
        return $brands;
    }
}

if (!function_exists('convertPrice')) {
    function convertPrice($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if ($business_settings != null) {
            $currency = Currency::find($business_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }
        $code = Currency::findOrFail(BusinessSetting::where('type', 'system_default_currency')->first()->value)->code;
        if (Session::has('currency_code')) {
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        } else {
            $currency = Currency::where('code', $code)->first();
        }
        $price = floatval($price) * floatval($currency->exchange_rate);
        return $price;
    }
}

if (!function_exists('convertCurrency')) {
    function convertCurrency($price, $price_currency_id)
    {
        $converted_price = 0;
        $currency = Currency::where('status', true)->where('code', env('DEFAULT_CURRENCY', 'USD'))->firstOrFail();
        if ($currency = Currency::findOrFail($price_currency_id)) {
            $converted_price = floatval($price) / floatval($currency->exchange_rate);
        }
        if ($business_settings = BusinessSetting::where('type', 'system_default_currency')->first()) {
            $currency = Currency::find($business_settings->value);
            $converted_price = floatval($converted_price) * floatval($currency->exchange_rate);
        }
        if ($converted_price != 0) {
            return round($converted_price, $currency->precision ?? (-2));
        }
        return round($price, $currency->precision ?? (-2));
    }
}
if (!function_exists('defaultCurrency')) {
    function defaultCurrency()
    {
        if ($business_settings = BusinessSetting::where('type', 'system_default_currency')->first()) {
            $currency = Currency::findOrFail($business_settings->value);
            return $currency->code;
        }
        if ($currency = Currency::where('status', true)->where('code', env('DEFAULT_CURRENCY', 'USD'))->firstOrFail()) {
            return $currency->code;
        }
        return "USD";
    }
}

if (!function_exists('defaultExchangeRate')) {
    function defaultExchangeRate()
    {
        if ($business_settings = BusinessSetting::where('type', 'system_default_currency')->first()) {
            $currency = Currency::findOrFail($business_settings->value);
            return $currency->exchange_rate;
        }
        if ($currency = Currency::where('status', true)->where('code', env('DEFAULT_ECHANGE_RATE', 'USD'))->firstOrFail()) {
            return $currency->exchange_rate;
        }
        return 1;
    }
}

function translate($key, $lang = null)
{
    if ($lang == null) {
        $lang = App::getLocale();
    }
    $translation_def = Translation::where('lang', default_language())->where('lang_key', $key)->first();
    if ($translation_def == null) {

        // if (env('DEMO_MODE') == 'Off') {
            foreach (Language::all() as $language) {
                // Translations
                $translation_def = Translation::firstOrNew(['lang' => $language->code, 'lang_key' => $key, 'lang_value'=>$key]);
                $translation_def->lang = $language->code;
                $translation_def->lang_key = $key;
                $translation_def->lang_value = $key;
                $translation_def->save();
            }
        // }
        // $translation_def = new Translation;
        // $translation_def->lang = env('DEFAULT_LANGUAGE', 'en');
        // $translation_def->lang_key = $key;
        // $translation_def->lang_value = $key;
        // $translation_def->save();
    }

    //Check for session lang
    $translation_locale = Translation::where('lang_key', $key)->where('lang', $lang)->first();
    if ($translation_locale != null && $translation_locale->lang_value != null) {
        return $translation_locale->lang_value;
    } elseif ($translation_def->lang_value != null) {
        return $translation_def->lang_value;
    } else {
        return $key;
    }
}

function remove_invalid_charcaters($str)
{
    $str = str_ireplace(array("\\"), '', $str);
    return str_ireplace(array('"'), '\"', $str);
}

function getShippingCost($index)
{
    $admin_products = array();
    $seller_products = array();
    $calculate_shipping = 0;

    foreach (Session::get('cart')->where('owner_id', Session::get('owner_id')) as $key => $cartItem) {
        $product = \App\Product::find($cartItem['id']);
        if ($product->added_by == 'admin') {
            array_push($admin_products, $cartItem['id']);
        } else {
            $product_ids = array();
            if (array_key_exists($product->user_id, $seller_products)) {
                $product_ids = $seller_products[$product->user_id];
            }
            array_push($product_ids, $cartItem['id']);
            $seller_products[$product->user_id] = $product_ids;
        }
    }

    //Calculate Shipping Cost
    if (get_setting('shipping_type') == 'flat_rate') {
        $calculate_shipping = \App\BusinessSetting::where('type', 'flat_rate_shipping_cost')->first()->value;
    } elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
        if (!empty($admin_products)) {
            $calculate_shipping = \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value;
        }
        if (!empty($seller_products)) {
            foreach ($seller_products as $key => $seller_product) {
                $calculate_shipping += \App\Shop::where('user_id', $key)->first()->shipping_cost;
            }
        }
    } elseif (get_setting('shipping_type') == 'area_wise_shipping') {
        $city = City::where('name', Session::get('shipping_info')['city'])->first();
        if ($city != null) {
            $calculate_shipping = $city->cost;
        }
    }

    $cartItem = Session::get('cart')[$index];
    $product = \App\Product::find($cartItem['id']);

    if (get_setting('shipping_type') == 'flat_rate') {
        return $calculate_shipping / count(Session::get('cart'));
    } elseif (get_setting('shipping_type') == 'seller_wise_shipping') {
        if ($product->added_by == 'admin') {
            return \App\BusinessSetting::where('type', 'shipping_cost_admin')->first()->value / count($admin_products);
        } else {
            return \App\Shop::where('user_id', $product->user_id)->first()->shipping_cost / count($seller_products[$product->user_id]);
        }
    } elseif (get_setting('shipping_type') == 'area_wise_shipping') {
        if ($product->added_by == 'admin') {
            return $calculate_shipping / count($admin_products);
        } else {
            return $calculate_shipping / count($seller_products[$product->user_id]);
        }
    } else {
        return \App\Product::find($cartItem['id'])->shipping_cost;
    }
}

function timezones()
{
    return Timezones::timezonesToArray();
}

if (!function_exists('app_timezone')) {
    function app_timezone()
    {
        return config('app.timezone');
    }
}

if (!function_exists('api_asset')) {
    function api_asset($id)
    {
        if (($asset = \App\Upload::find($id)) != null) {
            return 'public/' . $asset->file_name;
        }
        return null;
    }
}

//return file uploaded via uploader
if (!function_exists('uploaded_asset')) {
    function uploaded_asset($id)
    {
        if ($id != null && ($asset = \App\Upload::find($id)) != null) {
            return my_asset($asset->file_name);
        }
        return null;
    }
}

if (!function_exists('my_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function my_asset($path, $secure = null)
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return Storage::disk('s3')->url($path);
        } else {
            return app('url')->asset('public/' . $path, $secure);
        }
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}


if (!function_exists('isHttps')) {
    function isHttps()
    {
        return !empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS']);
    }
}

if (!function_exists('getBaseURL')) {
    function getBaseURL()
    {
        $root = (isHttps() ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

        return $root;
    }
}


if (!function_exists('getFileBaseURL')) {
    function getFileBaseURL()
    {
        if (env('FILESYSTEM_DRIVER') == 's3') {
            return env('AWS_URL') . '/';
        } else {
            return getBaseURL() . 'public/';
        }
    }
}


if (!function_exists('isUnique')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function isUnique($email)
    {
        $user = \App\User::where('email', $email)->first();

        if ($user == null) {
            return '1'; // $user = null means we did not get any match with the email provided by the user inside the database
        } else {
            return '0';
        }
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        if ($setting = BusinessSetting::where('type', $key)->first()) {
            return $setting->value;
        }
        return $setting ?? $default;
    }
}

function hex2rgba($color, $opacity = false)
{
    return Colorcodeconverter::convertHexToRgba($color, $opacity);
}

if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        if (Auth::check() && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('isSeller')) {
    function isSeller()
    {
        if (Auth::check() && Auth::user()->user_type == 'seller') {
            return true;
        }
        return false;
    }
}

if (!function_exists('isCustomer')) {
    function isCustomer()
    {
        if (Auth::check() && Auth::user()->user_type == 'customer') {
            return true;
        }
        return false;
    }
}

if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}

if (!function_exists('getProductAttributes')) {
    function getProductAttributes($products){
        // dd($products);
        $result=[];
        $attributes=[];
        foreach($products as $product){
            $attributes[]=json_decode($product->element->variations, true);
        }

        foreach($attributes as $attribute){
            $result=array_merge_recursive($result, $attribute);
        }
        // return drupal_array_merge_deep_array($attributes);
        // foreach($products as $product){
        //     $attributes[]=getAttributeFormat(json_decode($product->element->variations));
        // }
        // $result=drupal_array_merge_deep_array($attributes);
        // foreach($attributes as $attribute){

        // }
        // dd()
        return $result;
    }
}
if (!function_exists('getAttributeFormat')) {
    function getAttributeFormat($attributes){
        $collected_characteristics=[];
        if ($attributes) {
            foreach($attributes as $attribute_id=>$value_ids){
                if( is_array($value_ids) && count($value_ids)>0){
                    $characteristics=Characteristic::withTrashed()->whereIn('id',$value_ids)->get();
                    $attribute=Attribute::findOrFail($attribute_id);
                    $items=array();
                    foreach($characteristics as $characteristic){
                        $items[]=[
                            'id'=>$characteristic->id,
                            'name'=>$characteristic->getTranslation('name', app()->getLocale())
                        ];
                    }
                    if( is_array($items) && count($items)>0){
                        $collected_characteristics[]=[
                            'id'=>$attribute->id,
                            'attribute'=>$attribute->getTranslation('name', app()->getLocale()),
                            'values'=>$items
                        ];
                    }
                }
            }
        }
        return $collected_characteristics;
    }
}



 function calculateDeliveryCost($product, $address_id, $is_express=false){
    $seller=$product->user;
    if($seller_address=$seller->addresses->first()){
        $customer_address=Address::where('id', $address_id)->first();
        return calculateAllDeliveryCost($seller_address, $customer_address, calculateWeightCost($product), $is_express);
    }else{
        return -2;
    }

}

 function calculateWeightCost($product){
    $weight_price=0;
    if($weight_setting=SellerSetting::where('type', 'kg_weight_price')->where('user_id', $product->user_id)->first()){
        $weight_price=convertCurrency((double)$weight_setting->value, (int)$weight_setting->relation_id);
    }else if($weight_setting=SellerSetting::where('type', 'kg_weight_price')->first()){
        $weight_price=convertCurrency((double)$weight_setting->value, (int)$weight_setting->relation_id);
    }
    return $weight_price*((double)$product->element->weight);
}

 function calculateAllDeliveryCost($seller_address, $client_address, $weight_cost=0, $is_express=false){
    //region -> Viloyat
    //city -> Shahar yoki tuman
    $all_distance=-1;
    $delivery_cost=0;
    $inline_cost=0;
    $delivery_metrics=null;
    if($seller_address->region->id==$client_address->region->id){
        $inline_cost=$seller_address->city->inside_price;
        $all_distance=0;
    }else{
        $distance_between_regions=DB::table('delivery')->where('seller_region_id', $seller_address->region->id)->where('client_region_id', $client_address->region->id)->first();
        if($distance_between_regions==null){
            $distance_between_regions=DB::table('delivery')->where('seller_region_id', $client_address->region->id)->where('client_region_id', $seller_address->region->id)->first();
        }
        if($distance_between_regions){
            if($client_address->city->distance==0){
                $inline_cost=$inline_cost+$client_address->city->inside_price;
            }
            if($seller_address->city->distance==0){
                $inline_cost=$inline_cost+$seller_address->city->inside_price;
            }
            $all_distance=$seller_address->city->distance + $distance_between_regions->distance + $client_address->city->distance;
        }else{
            $all_distance=-2;//distance not found
        }
    }

    if($all_distance>0){
        if($delivery_metrics=Delivery::orderBy('distance', 'asc')->where('user_id', $seller_address->user_id)->where('distance', '>', $all_distance)->first()){
        }else{
            $delivery_metrics=Delivery::orderBy('distance', 'asc')->where('distance', '>', $all_distance)->first();
        }
        // dd( $delivery_metrics);

        if($is_express){
            $express_percent=-1;
            if($express_percent_model=SellerSetting::where('type', 'express_percent')->where('user_id', $seller_address->user_id)->first()){
                if($express_distance_model=SellerSetting::where('type', 'express_distance')->where('user_id', $seller_address->user_id)->first()){
                    if($express_distance_model->value>$all_distance){
                        $express_percent=$express_percent_model->value;
                    }else{
                        $express_percent=-2;
                    }
                }else{
                    $express_distance_model=SellerSetting::where('type', 'express_distance')->first();
                    if($express_distance_model->value>$all_distance){
                        $express_percent=$express_percent_model->value;
                    }else{
                        $express_percent=-2;
                    }
                }
            }else{

                $express_percent_model=SellerSetting::where('type', 'express_percent')->first();
                $express_distance_model=SellerSetting::where('type', 'express_distance')->first();
                if($express_distance_model->value>$all_distance){
                    $express_percent=$express_percent_model->value;
                }else{
                    $express_percent=-2;
                }
            }

            if($express_percent>0){
                $delivery_cost= ($delivery_metrics->price*$all_distance)*(100+$express_percent)/100+$weight_cost;
            }else if($express_percent==0){
                $delivery_cost= ($delivery_metrics->price*$all_distance)+$weight_cost;
            }else{
                $delivery_cost = -3; //Not valid
            }
        }else{
            $delivery_cost= $delivery_metrics->price*$all_distance+$weight_cost;
        }
    }else if($all_distance==0){
        $delivery_cost = $weight_cost;
    }else{
        $delivery_cost=-2;//distance not found
    }
    if($delivery_cost>0){
        // $delivery_cost=convertCurrency((double)$delivery_cost, Currency::where('code', defaultCurrency())->first()->id);
    }
    // dd($weight_cost);
    if($delivery_metrics){
        return [
            'days'=>$delivery_metrics->days,
            'cost'=>$delivery_cost
        ];
    }else{
        return [
            'days'=>-1,
            'cost'=>$delivery_cost
        ];
    }
}
// function calculateShipping($request){
//     $product=Product::where('id', $request['product_id'])->first();
//     if($request['type']=='precise' && $request['address_id']!=null){
//         return calculateDeliveryCost($product, $request['address_id']);
//     }else{
//         $user_region=City::where('id', $request['region_id'])->where('type', 'region');
//         $address=Address::firstOrNew(['region_id'=>$user_region->id]);
//         $address->save();
//         return calculateDeliveryCost($product, $address->id);
//     }
//     return 0;
// }

function getUserAddress(){
    $address=Address::firstOrNew(['user_id' => 0, 'address' => null, 'city_id'=>getDefaultCity(), 'region_id'=>getDefaultRegion()]);
    if(Auth::check()){
        $user=User::where('id',auth()->id())->first();
        if(count($user->addresses)==1){
            $address=$user->addresses->first();
        }else if(count($user->addresses)>1){
            $address=$user->addresses->where('set_default', 1)->first();
        }else if($user_setting=SellerSetting::where('type', 'default_address')->where('user_id', auth()->id())->first()){
            $address=Address::firstOrNew(['user_id' => 0, 'address' => null, 'city_id'=>$user_setting->value, 'region_id'=>$user_setting->relation_id]);
        }else if($user_setting=SellerSetting::where('type', 'default_address')->first()){
            $address=Address::firstOrNew(['user_id' => 0, 'address' => null, 'city_id'=>$user_setting->value, 'region_id'=>$user_setting->relation_id]);
        }
    }else if($ip_address=IpAddress::where('ip', getClientIp())->first()){
        $address=Address::firstOrNew(['user_id' => 0, 'address' => null, 'city_id'=>$ip_address->city_id??getDefaultCity(), 'region_id'=>$ip_address->region_id??getDefaultRegion()]);
    }
    $address->save();
    return $address;
}

// function getCompanyAddress(){
//     $user=User::where('user_type', 'admin')->first();
//     if(count($user->addresses)==1){
//         $address=$user->addresses->first();
//     }else if(count($user->addresses)>1){
//         $address=$user->addresses->where('set_default', 1)->first();
//     }else if($user_setting=SellerSetting::where('type', 'default_address')->where('user_id', auth()->id())->first()){
//         $address=Address::firstOrNew(['user_id' => 0, 'address' => null, 'city_id'=>$user_setting->value, 'region_id'=>$user_setting->relation_id]);
//     }else if($user_setting=SellerSetting::where('type', 'default_address')->first()){
//         $address=Address::firstOrNew(['user_id' => 0, 'address' => null, 'city_id'=>$user_setting->value, 'region_id'=>$user_setting->relation_id]);
//     }else{
//         $address=Address::firstOrNew(['user_id' => 0, 'address' => null, 'city_id'=>getDefaultCity(), 'region_id'=>getDefaultRegion()]);
//     }
//     $address->save();
//     return $address;
// }

function getDefaultCity(){
    return 57;
}

function getDefaultRegion(){
    return 281;
}

if (!function_exists('getClientIp')) {
    function getClientIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}
