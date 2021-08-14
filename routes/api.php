<?php

// use \App\Http\Controllers\Api\SearchController;



use Illuminate\Support\Facades\Route;

// use Razorpay\Api\Api;
Route::get('mytest', function () {
    //single product
    $products=getPublishedProducts()->limit(10)->get();
    $collection=new App\Http\Resources\ProductCollection($products);
    $data=$collection;

    //products detail
    // $product=getPublishedProducts()->first();
    // $colection=new App\Http\Resources\ProductDetailCollection($product);
    // $data=$colection;

    return $data;
});

Route::prefix('v1/auth')->group(function () {
    Route::post('login', 'Api\AuthController@login');
    Route::post('signinByPhoneNumber', 'Api\AuthController@signinByPhoneNumber');
    Route::post('registerPhoneNumber', 'Api\AuthController@registerPhoneNumber');
    Route::post('registerSeller', 'Api\AuthController@registerSeller');
    Route::post('loginSeller/{id}', 'Api\AuthController@loginSeller');
    Route::post('signup', 'Api\AuthController@signup');
    Route::post('social-login', 'Api\AuthController@socialLogin');
    Route::post('password/create', 'Api\PasswordResetController@create');
    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('user', 'Api\AuthController@user');
    });
});

Route::prefix('v1')->group(function () {
    Route::get('/verification/form', 'Api\VerificationController@form');
    Route::match(['get', 'post'], '/nested/categories', 'Api\CategoryController@all');
    Route::get('/get/all/products', 'Api\ProductController@getAllProducts');
    Route::match(['get','post'], '/free/shipping/products','Api\ProductController@freeShippingProduct');
    Route::match(['get','post'], '/free/featured/products','Api\FlashDealController@featuredProduct');
    Route::match(['get','post'], '/super/discount/products','Api\FlashDealController@superDiscount');
    // End Time for Discount, need to integrate to Product Detail Collection
    Route::match(['get','post'], '/super/discount/endtime','Api\FlashDealController@discountEndDate');
//
    Route::match(['post'], '/store/review', 'Api\ReviewController@store');
    Route::match(['get', 'post'], '/get/page', 'Api\PageController@page');
    Route::match(['get', 'post'], '/get/pages', 'Api\PageController@pages');
    Route::match(['get', 'post'], '/get/footer-pages', 'Api\PageController@footer_pages');

    Route::match(['get', 'post'], '/sellers', 'Api\SellerController@sellers');
    Route::match(['get', 'post'], '/sellers/{id}', 'Api\SellerController@seller');
    Route::match(['get', 'post'], '/shop/{id}', 'Api\SellerController@shop');
    Route::match(['get', 'post'], '/shop/{id}/all-products', 'Api\SellerController@shopAllProducts');
    Route::match(['get', 'post'], '/shop/{id}/featured-products', 'Api\SellerController@shopFeaturedProducts');
    Route::match(['get', 'post'], '/shop/{id}/top-selling-products', 'Api\SellerController@shopTopSelling');
    Route::match(['get', 'post'], '/sellers/{id}/top-selling', 'Api\SellerController@topSelling');
    Route::match(['get', 'post'], '/sellers/{id}/featured-products', 'Api\SellerController@featuredProducts');
    Route::match(['get', 'post'], '/sellers/{id}/all-products', 'Api\SellerController@allProducts');
   // Route::get('get/seller', 'Api\SellerController@sellers');

    Route::match(['get', 'post'], '/user/addresses', 'Api\OrderController@getUserAddress');
    Route::match(['get', 'post'], '/store/user/addresses', 'Api\OrderController@storeUserAddress')->middleware('auth:api');
    Route::match(['get', 'post'], '/delete/user/addresses', 'Api\OrderController@deleteUserAddress')->middleware('auth:api');
    Route::match(['get', 'post'], '/pick-up-points', 'Api\OrderController@getPickUpPoints');
    Route::match(['get', 'post'], '/payment-methods', 'Api\OrderController@paymentMethods');


//    Route::apiResource('banners', 'Api\BannerController')->only('index');
    Route::match(['get', 'post'], '/ajax_search', 'Api\SearchController@ajax_search');
    Route::match(['get', 'post'], '/search-by-category', 'Api\SearchController@searchByHashtags');
    Route::match(['get', 'post'], '/banners', 'App\Http\Controllers\Api\V2\HomePageController@banners');
    Route::match(['get', 'post'], '/user/orders', 'Api\OrderController@userOrders'); //->middleware('auth:api');
    Route::match(['get', 'post'], '/make/orders', 'Api\OrderController@processApiCheckout'); //->middleware('auth:api');

    Route::apiResource('banners', 'Api\BannerController')->only('index');

    Route::get('brands/top', 'Api\BrandController@top');
    Route::apiResource('brands', 'Api\BrandController')->only('index');


    Route::apiResource('business-settings', 'Api\BusinessSettingController')->only('index');

    Route::get('filter/all/{type}/{id}', 'Api\ProductController@getAllBySlug');

    Route::get('categories/featured', 'Api\CategoryController@featured');
    Route::get('categories/home', 'Api\CategoryController@home');
    Route::apiResource('categories', 'Api\CategoryController')->only('index');
    Route::match(['get', 'post'], '/all-categories', 'Api\CategoryController@allCategories');
    Route::get('sub-categories/{id}', 'Api\SubCategoryController@index')->name('subCategories.index');
    Route::get('category/sub-categories/{id}', 'Api\SubCategoryController@subCategories')->name('subCategories.category');
//    Route::get('sub-categories2/{id}', 'Api\SubCategoryController@index2')->name('subCategories.index');

    Route::apiResource('colors', 'Api\ColorController')->only('index');

    Route::apiResource('currencies', 'Api\CurrencyController')->only('index');

    Route::apiResource('customers', 'Api\CustomerController')->only('show');

    Route::apiResource('general-settings', 'Api\GeneralSettingController')->only('index');

    Route::apiResource('home-categories', 'Api\HomeCategoryController')->only('index');

    // Route::get('test/attribute','Api\AttributeController@index');
    //  Route::get('test/branch','Api\BranchController@index');
    // Route::get('test/variation','Api\VariationController@index');

    Route::get('purchase-history/{id}', 'Api\PurchaseHistoryController@index')->middleware('auth:api');
    Route::get('purchase-history-details/{id}', 'Api\PurchaseHistoryDetailController@index')->name('purchaseHistory.details')->middleware('auth:api');
    Route::get('products/detail/{id}', 'Api\ProductController@show');

    Route::get('products/admin', 'Api\ProductController@admin');
    Route::get('products/seller', 'Api\ProductController@seller');
    Route::get('products/category/{id}', 'Api\ProductController@category')->name('api.products.category');
    Route::get('products/featured/category/{slug}', 'Api\ProductController@featuredCategoryProducts');
    Route::get('products/sub-category/{id}', 'Api\ProductController@subCategory')->name('products.subCategory');
    Route::get('products/sub-sub-category/{id}', 'Api\ProductController@subSubCategory')->name('products.subSubCategory');
    Route::get('products/brand/{id}', 'Api\ProductController@brand')->name('api.products.brand');
    Route::get('products/todays-deal', 'Api\ProductController@todaysDeal');
    Route::get('products/new-products', 'Api\ProductController@newProducts');
    Route::get('products/flash-deals', 'Api\ProductController@flashDeal');
    Route::get('products/flash-deal/{id}', 'Api\ProductController@singleFlashDeal');
    Route::get('products/featured', 'Api\ProductController@featured');
    Route::get('products/featured-flash-deals', 'Api\ProductController@featuredFlashDeals');
    Route::get('products/featured-flash-deal/{id}', 'Api\ProductController@singleFeaturedFlashDeal');
    Route::get('products/best-seller', 'Api\ProductController@bestSeller');
    Route::get('products/related/{id}', 'Api\ProductController@related')->name('products.related');
    Route::get('products/top-from-seller/{id}', 'Api\ProductController@topFromSeller')->name('products.topFromSeller');
    Route::get('products/search', 'Api\ProductController@search');
    Route::post('products/variant/price', 'Api\ProductController@variantPrice');
    Route::get('products/home', 'Api\ProductController@home');
    Route::get('products/index', 'Api\ProductController@home');
    Route::apiResource('products', 'Api\ProductController')->except(['store', 'update', 'destroy']);
    // Route::get('brand/{name}','Api\ProductController@byBrand');
//    Route::get('products/byBrand/{name}','Api\ProductController');


    // Route::get('carts/{id}', 'Api\CartController@index')->middleware('auth:api');
    Route::post('carts/add', 'Api\CartController@add')->middleware('auth:api');
    Route::post('carts/change-quantity', 'Api\CartController@changeQuantity')->middleware('auth:api');
    Route::apiResource('carts', 'Api\CartController')->except(['store', 'edit', 'update', 'show'])->middleware('auth:api');

    Route::get('reviews/product/{id}', 'Api\ReviewController@index')->name('api.reviews.index');

    Route::get('shop/user/{id}', 'Api\ShopController@shopOfUser')->middleware('auth:api');
    Route::get('shops/details/{id}', 'Api\ShopController@info')->name('shops.info');
    Route::get('shops/products/all/{id}', 'Api\ShopController@allProducts')->name('shops.allProducts');
    Route::get('shops/products/top/{id}', 'Api\ShopController@topSellingProducts')->name('shops.topSellingProducts');
    Route::get('shops/products/featured/{id}', 'Api\ShopController@featuredProducts')->name('shops.featuredProducts');
    Route::get('shops/products/new/{id}', 'Api\ShopController@newProducts')->name('shops.newProducts');
    Route::get('shops/brands/{id}', 'Api\ShopController@brands')->name('shops.brands');
    Route::apiResource('shops', 'Api\ShopController')->only('index');

    Route::apiResource('sliders', 'Api\SliderController')->only('index');

    // Route::get('wishlists/{id}', 'Api\WishlistController@index')->middleware('auth:api');
    Route::post('wishlists/check-product', 'Api\WishlistController@isProductInWishlist')->middleware('auth:api');
    Route::apiResource('wishlists', 'Api\WishlistController')->except(['update', 'show'])->middleware('auth:api');

    Route::apiResource('settings', 'Api\SettingsController')->only('index');

    Route::get('policies/seller', 'Api\PolicyController@sellerPolicy')->name('policies.seller');
    Route::get('policies/support', 'Api\PolicyController@supportPolicy')->name('policies.support');
    Route::get('policies/return', 'Api\PolicyController@returnPolicy')->name('policies.return');

    Route::match(['get', 'post'], 'user/info/update', 'Api\UserController@updateUser');
    Route::get('user/info/{id}', 'Api\UserController@info')->middleware('auth:api');
    Route::get('user/shipping/address/{id}', 'Api\AddressController@addresses')->middleware('auth:api');
    Route::post('user/shipping/create', 'Api\AddressController@createShippingAddress')->middleware('auth:api');
    Route::get('user/shipping/delete/{id}', 'Api\AddressController@deleteShippingAddress')->middleware('auth:api');
    // Route::get('user/shipping/cost/{product_id}/{region_id}', 'Api\ProductController@calculateShipping')->middleware('auth:api');

    Route::post('coupon/apply', 'Api\CouponController@apply')->middleware('auth:api');

    Route::post('payments/pay/stripe', 'Api\StripeController@processPayment')->middleware('auth:api');
    Route::post('payments/pay/paypal', 'Api\PaypalController@processPayment')->middleware('auth:api');
    Route::post('payments/pay/wallet', 'Api\WalletController@processPayment')->middleware('auth:api');
    Route::post('payments/pay/cod', 'Api\PaymentController@cashOnDelivery')->middleware('auth:api');

    //  {{communication}}
    Route::post('post/conversation','Api\ConversationController@postConversations');
    Route::post('post/subscriber','Api\SubscriberController@postSubscribers');
    Route::post('post/found_it_cheaper','Api\FoundItCheaperController@postFoundItCheaper');
    Route::post('post/report_description','Api\ReportDescriptionController@postReportDescription');
    Route::post('post/support_service','Api\SupportServiceController@postSupportService');

    Route::post('order/store', 'Api\OrderController@store')->middleware('auth:api');

    Route::get('wallet/balance/{id}', 'Api\WalletController@balance')->middleware('auth:api');
    Route::get('wallet/history/{id}', 'Api\WalletController@walletRechargeHistory')->middleware('auth:api');

    Route::match(['get', 'post'], 'search', 'SearchController@search');
    // Route::match(['get', 'post'], 'test',  function(){
    //     $attribute= \App\Product::all();
    //     $data = new \App\Http\Resources\ProductCollection($attribute);
    //     // dd($data[0]);
    //     return response()->json($data);
    // });

    Route::get('conversation_messages','Api\ConversationController@getConversations');//->middleware('auth:api');
    Route::post('send_conversation_message','Api\ConversationController@store');//->middleware('auth:api');


    Route::get('/countries', 'Api\CityController@countries');
    Route::get('/regions/{country_id}', 'Api\CityController@countryRegions');
    Route::get('/cities/{region_id}', 'Api\CityController@regionCities');
    Route::get('/cities', 'Api\CityController@selectedCities');
    Route::post('/cities', 'Api\CityController@search');
    // Route::get('/region/{id}/cities', 'Api\CityController@cities');
    Route::get('/region/{country_id}/{region_id}/cities', 'Api\CityController@regions');
    Route::get('register/me', 'Api\ProductController@setLocationSetting');
    Route::get('get/me', 'Api\ProductController@getLocationSetting');

});

Route::fallback(function() {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});
