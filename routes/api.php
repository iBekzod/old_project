<?php

// use \App\Http\Controllers\Api\SearchController;



use Illuminate\Support\Facades\Route;
// use Razorpay\Api\Api;

// use Razorpay\Api\Api;
// Route::get('mytest', function () {
//     //single product
//     $products=getPublishedProducts()->limit(10)->get();
//     $collection=new App\Http\Resources\ProductCollection($products);
//     $data=$collection;

//     //products detail
//     // $product=getPublishedProducts()->first();
//     // $colection=new App\Http\Resources\ProductDetailCollection($product);
//     // $data=$colection;

//     return $data;
// });




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
    Route::post('change-cart-address', 'Api\OrderController@apply_carts_address')->middleware('auth:api');
    Route::match(['get', 'post'], '/translate', 'Api\FrontendController@getFrontendTranslation');
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

    // orders
    Route::match(['get', 'post'], '/user/addresses', 'Api\OrderController@getUserAddress');
    Route::match(['get', 'post'], '/store/user/addresses', 'Api\OrderController@storeUserAddress')->middleware('auth:api');
    Route::match(['get', 'post'], '/delete/user/addresses', 'Api\OrderController@deleteUserAddress')->middleware('auth:api');
    Route::match(['get', 'post'], '/pick-up-points', 'Api\OrderController@getPickUpPoints');
    Route::match(['get', 'post'], '/payment-methods', 'Api\OrderController@paymentMethods');
    Route::match(['get', 'post'], '/user/orders', 'Api\OrderController@userOrders')->middleware('auth:api');
    Route::match(['get', 'post'], 'custom/user/orders', 'Api\OrderController@customUserOrders')->middleware('auth:api');
    Route::match(['get', 'post'], '/make/orders', 'Api\OrderController@store')->middleware('auth:api');


    //    Route::apiResource('banners', 'Api\BannerController')->only('index');
    Route::match(['get', 'post'], '/ajax_search', 'Api\SearchController@ajax_search');
    Route::match(['get', 'post'], '/search-by-category', 'Api\SearchController@searchByHashtags');
    Route::match(['get', 'post'], '/banners', 'Api\V2\HomePageController@banners');


    Route::apiResource('banners', 'Api\BannerController')->only('index');

    Route::get('brands/top', 'Api\BrandController@top');
    Route::apiResource('brands', 'Api\BrandController')->only('index');


    Route::apiResource('business-settings', 'Api\BusinessSettingController')->only('index');

    Route::get('filter/all/{type}/{id}', 'Api\ProductController@getAllBySlug');
    Route::get('check-product-exists', 'Api\ProductController@checkProductExists');

    Route::get('categories/featured', 'Api\CategoryController@featured');
    Route::get('categories/home', 'Api\CategoryController@home');
    Route::apiResource('categories', 'Api\CategoryController')->only('index');
    Route::match(['get', 'post'], '/all-categories', 'Api\CategoryController@allCategories');
    Route::get('sub-categories/{id}', 'Api\SubCategoryController@index')->name('subCategories.index');
    Route::get('category/sub-categories/{id}', 'Api\SubCategoryController@subCategories')->name('subCategories.category');
    //    Route::get('sub-categories2/{id}', 'Api\SubCategoryController@index2')->name('subCategories.index');

    Route::apiResource('colors', 'Api\ColorController')->only('index');
    Route::apiResource('reasons', 'Api\ReasonController')->only('index');

    Route::apiResource('currencies', 'Api\CurrencyController')->only('index');

    Route::apiResource('customers', 'Api\CustomerController')->only('show');

    Route::apiResource('general-settings', 'Api\GeneralSettingController')->only('index');

    Route::apiResource('home-categories', 'Api\HomeCategoryController')->only('index');

    // Route::get('test/attribute','Api\AttributeController@index');
    //  Route::get('test/branch','Api\BranchController@index');
    // Route::get('test/variation','Api\VariationController@index');

    Route::get('purchase-history', 'Api\PurchaseHistoryController@index')->middleware('auth:api');
    Route::get('purchase-history-bought', 'Api\PurchaseHistoryController@boughtProducts')->middleware('auth:api');
    Route::get('purchase-history-refunded', 'Api\PurchaseHistoryController@refundedProducts')->middleware('auth:api');
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
    Route::get('cart-summary/{user_id}/{owner_id}', 'Api\CartController@summary')->middleware('auth:api');
    Route::post('carts/process', 'Api\CartController@process')->middleware('auth:api');
    Route::post('carts/{user_id}', 'Api\CartController@getList')->middleware('auth:api');
    Route::post('carts/process-shipping-cost', 'Api\CartController@calculate_current_cart_shipping_cost')->middleware('auth:api');

    // {{ product-reviews }}
    Route::get('reviews/user', 'Api\ReviewController@userReview')->middleware('auth:api');
    Route::get('reviews/product/{id}', 'Api\ReviewController@index')->name('api.reviews.index');
    Route::post('reviews/submit', 'Api\ReviewController@submit')->middleware('auth:api');


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

    Route::post('user/info/update', 'Api\UserController@updateUser')->middleware('auth:api');
    Route::get('user/info/{id}', 'Api\UserController@info')->middleware('auth:api');
    // Route::get('user/shipping/address/{id}', 'Api\AddressController@addresses')->middleware('auth:api');
    // Route::post('user/shipping/create', 'Api\AddressController@createShippingAddress')->middleware('auth:api');
    // Route::get('user/shipping/delete/{id}', 'Api\AddressController@deleteShippingAddress')->middleware('auth:api');


    Route::get('user/shipping/address/{id}', 'Api\V2\AddressController@addresses')->middleware('auth:api');
    Route::post('user/shipping/create', 'Api\V2\AddressController@createShippingAddress')->middleware('auth:api');
    Route::post('user/shipping/update', 'Api\V2\AddressController@updateShippingAddress')->middleware('auth:api');
    Route::post('user/shipping/update-location', 'Api\V2\AddressController@updateShippingAddressLocation')->middleware('auth:api');
    Route::post('user/shipping/make_default', 'Api\V2\AddressController@makeShippingAddressDefault')->middleware('auth:api');
    Route::get('user/shipping/delete/{id}', 'Api\V2\AddressController@deleteShippingAddress')->middleware('auth:api');
    Route::post('update-address-in-cart', 'Api\V2\AddressController@updateAddressInCart')->middleware('auth:api');

    // Route::get('user/shipping/cost/{product_id}/{region_id}', 'Api\ProductController@calculateShipping')->middleware('auth:api');

    // {{ Coupon }}
    Route::post('coupon/apply', 'Api\CouponController@apply')->middleware('auth:api');
    Route::get('coupon/usage', 'Api\CouponController@index')->middleware('auth:api');

    Route::post('payments/pay/stripe', 'Api\StripeController@processPayment')->middleware('auth:api');
    Route::post('payments/pay/paypal', 'Api\PaypalController@processPayment')->middleware('auth:api');
    Route::post('payments/pay/wallet', 'Api\WalletController@processPayment')->middleware('auth:api');
    Route::post('payments/pay/cod', 'Api\PaymentController@cashOnDelivery')->middleware('auth:api');

    //  {{refund_requset}}
    Route::apiResource('reasons', 'Api\ReasonController')->only('index');
    Route::post('refund-request-send', 'Api\RefundRequestController@request_store')->middleware('auth:api');
    Route::get('refund-request', 'Api\RefundRequestController@index')->middleware('auth:api');
    Route::get('sent-refund-request', 'Api\RefundRequestController@customer_index')->middleware('auth:api');
    Route::post('refund-reuest-vendor-approval', 'Api\RefundRequestController@request_approval_vendor')->middleware('auth:api');
    // Route::get('refund-request', 'Api\RefundRequestController@refund_request_send_page')->middleware('auth:api');
    Route::post('reject-refund-request','Api\RefundRequestController@reject_refund_request')->middleware('auth:api');
    Route::get('refund-request-reason', 'Api\RefundRequestController@reason_view')->middleware('auth:api');
    Route::get('refund-request-reject-reason', 'Api\RefundRequestController@reject_reason_view')->middleware('auth:api');
    // Route::get('paid-refund', 'Api\RefundRequestController@paid_index')->middleware('auth:api');
    Route::get('paid-refund', 'Api\RefundRequestController@paid_index')->middleware('auth:api');
    Route::get('rejected-refund', 'Api\RefundRequestController@rejected_index')->middleware('auth:api');
    //  {{SupportTicket}}
	Route::post('post/support-ticket','Api\SupportTicketController@post_store')->middleware('auth:api');
    Route::get('get/support-ticket', 'Api\SupportTicketController@index')->middleware('auth:api');

    Route::get('show/support-ticket/{code}', 'Api\SupportTicketController@show')->middleware('auth:api');
    Route::post('send-ticket-reply','Api\SupportTicketController@send_ticket_reply')->middleware('auth:api');

	// Route::post('support_ticket/reply','SupportTicketController@seller_store')->name('support_ticket.seller_store');

    // club point {ball}
    Route::get('earning-points', 'Api\ClubPointController@userpoint_index')->middleware('auth:api');
    Route::post('convert-point-into-wallet', 'Api\ClubPointController@convert_point_into_wallet')->middleware('auth:api');
    Route::get('club-point-details/{club_point_id}', 'Api\ClubPointController@club_point_detail')->middleware('auth:api');

    //  {{communication}}
    Route::post('post/conversation','Api\ConversationController@postConversations')->middleware('auth:api');
    Route::get('get/conversation','Api\ConversationController@getConversations')->middleware('auth:api');

    Route::get('get/conversation/{id}','Api\ConversationController@show')->middleware('auth:api');
    Route::post('post/conversation/message','Api\ConversationController@message')->middleware('auth:api');


    Route::post('post/subscriber','Api\SubscriberController@postSubscribers');
    Route::post('post/found_it_cheaper','Api\FoundItCheaperController@postFoundItCheaper');
    // Route::post('post/report_description','Api\ReportDescriptionController@postReportDescription');
    Route::post('post/support_service','Api\SupportServiceController@postSupportService')->middleware('auth:api');

    Route::post('order/store', 'Api\OrderController@processOrder')->middleware('auth:api');

    Route::get('wallet/balance/{id}', 'Api\WalletController@balance')->middleware('auth:api');
    Route::get('wallet/history/{id}', 'Api\WalletController@walletRechargeHistory')->middleware('auth:api');

    Route::match(['get', 'post'], 'search', 'SearchController@search');
    // Route::match(['get', 'post'], 'test',  function(){
    //     $attribute= \App\Product::all();
    //     $data = new \App\Http\Resources\ProductCollection($attribute);
    //     // dd($data[0]);
    //     return response()->json($data);
    // });

    // Route::get('conversation_messages','Api\ConversationController@getConversations');//->middleware('auth:api');
    // Route::post('send_conversation_message','Api\ConversationController@store');//->middleware('auth:api');


    Route::get('/countries', 'Api\CityController@countries');
    Route::get('/regions/{country_id}', 'Api\CityController@countryRegions');
    Route::get('/cities/{region_id}', 'Api\CityController@regionCities');
    Route::get('/cities', 'Api\CityController@selectedCities');
    Route::post('/cities', 'Api\CityController@search');
    Route::get('/current_location', 'Api\CityController@getCurrentLocation');

    // Route::get('/region/{id}/cities', 'Api\CityController@cities');
    Route::get('/region/{country_id}/{region_id}/cities', 'Api\CityController@regions');
    Route::get('register/me', 'Api\ProductController@setLocationSetting');
    Route::get('get/me', 'Api\ProductController@getLocationSetting');
    Route::post('/send-sms', 'SmsController@send');
    Route::post('/change-language', 'Api\LanguageController@changeLanguage');
    Route::get('/languages', 'Api\LanguageController@index');
    Route::get('/tranlate-type', 'Api\FrontendController@getMobile');
});

Route::prefix('v2/auth')->group(function () {
    Route::post('login', 'Api\V2\AuthController@login');
    Route::post('signinByPhoneNumber', 'Api\AuthController@signinByPhoneNumber');
    Route::post('registerPhoneNumber', 'Api\AuthController@registerPhoneNumber');
    Route::post('signup', 'Api\V2\AuthController@signup');
    Route::post('social-login', 'Api\V2\AuthController@socialLogin');
    Route::post('password/forget_request', 'Api\V2\PasswordResetController@forgetRequest');
    Route::post('password/confirm_reset', 'Api\V2\PasswordResetController@confirmReset');
    Route::post('password/resend_code', 'Api\V2\PasswordResetController@resendCode');
    Route::middleware('auth:api')->group(function () {
        Route::get('logout', 'Api\V2\AuthController@logout');
        Route::get('user', 'Api\V2\AuthController@user');
    });
    Route::post('resend_code', 'Api\V2\AuthController@resendCode');
    Route::post('confirm_code', 'Api\V2\AuthController@confirmCode');
});

Route::prefix('v2')->group(function () {

    Route::match(['get', 'post'], '/translate', 'Api\FrontendController@getFrontendTranslation');
    Route::prefix('delivery-boy')->group(function () {
        Route::get('dashboard-summary/{id}', 'Api\V2\DeliveryBoyController@dashboard_summary')->middleware('auth:api');
        Route::get('deliveries/completed/{id}', 'Api\V2\DeliveryBoyController@completed_delivery')->middleware('auth:api');
        Route::get('deliveries/cancelled/{id}', 'Api\V2\DeliveryBoyController@cancelled_delivery')->middleware('auth:api');
        Route::get('deliveries/on_the_way/{id}', 'Api\V2\DeliveryBoyController@on_the_way_delivery')->middleware('auth:api');
        Route::get('deliveries/picked_up/{id}', 'Api\V2\DeliveryBoyController@picked_up_delivery')->middleware('auth:api');
        Route::get('deliveries/assigned/{id}', 'Api\V2\DeliveryBoyController@assigned_delivery')->middleware('auth:api');
        Route::get('collection-summary/{id}', 'Api\V2\DeliveryBoyController@collection_summary')->middleware('auth:api');
        Route::get('earning-summary/{id}', 'Api\V2\DeliveryBoyController@earning_summary')->middleware('auth:api');
        Route::get('collection/{id}', 'Api\V2\DeliveryBoyController@collection')->middleware('auth:api');
        Route::get('earning/{id}', 'Api\V2\DeliveryBoyController@earning')->middleware('auth:api');
        Route::post('cancel-request', 'Api\V2\DeliveryBoyController@cancel_request')->middleware('auth:api');
        Route::post('change-delivery-status', 'Api\V2\DeliveryBoyController@change_delivery_status')->middleware('auth:api');
    });

    Route::apiResource('reasons', 'Api\ReasonController')->only('index');
    Route::post('refund-request-send', 'Api\RefundRequestController@request_store')->middleware('auth:api');
    Route::get('refund-request', 'Api\RefundRequestController@vendor_index')->middleware('auth:api');
    Route::get('sent-refund-request', 'Api\RefundRequestController@customer_index')->middleware('auth:api');
    Route::post('refund-reuest-vendor-approval', 'Api\RefundRequestController@request_approval_vendor')->middleware('auth:api');
    Route::get('refund-request', 'Api\RefundRequestController@refund_request_send_page')->middleware('auth:api');
    Route::post('reject-refund-request','Api\RefundRequestController@reject_refund_request')->middleware('auth:api');
    Route::get('refund-request-reason', 'Api\RefundRequestController@reason_view')->middleware('auth:api');
    Route::get('refund-request-reject-reason', 'Api\RefundRequestController@reject_reason_view')->middleware('auth:api');

    Route::get('chat/conversations/{id}', 'Api\V2\ChatController@conversations')->middleware('auth:api');
    Route::get('chat/messages/{id}', 'Api\V2\ChatController@messages')->middleware('auth:api');
    Route::post('chat/insert-message', 'Api\V2\ChatController@insert_message')->middleware('auth:api');
    Route::get('chat/get-new-messages/{conversation_id}/{last_message_id}', 'Api\V2\ChatController@get_new_messages')->middleware('auth:api');
    Route::post('chat/create-conversation', 'Api\V2\ChatController@create_conversation')->middleware('auth:api');

    Route::apiResource('banners', 'Api\V2\BannerController')->only('index');

    Route::get('brands/top', 'Api\V2\BrandController@top');
    Route::apiResource('brands', 'Api\V2\BrandController')->only('index');

    Route::apiResource('business-settings', 'Api\V2\BusinessSettingController')->only('index');

    Route::get('categories/featured', 'Api\V2\CategoryController@featured');
    Route::get('categories/home', 'Api\V2\CategoryController@home');
    Route::get('categories/top', 'Api\V2\CategoryController@top');
    Route::apiResource('categories', 'Api\V2\CategoryController')->only('index');
    Route::get('sub-categories/{id}', 'Api\V2\SubCategoryController@index')->name('subCategories.index');

    Route::apiResource('colors', 'Api\V2\ColorController')->only('index');

    Route::apiResource('currencies', 'Api\V2\CurrencyController')->only('index');

    Route::apiResource('customers', 'Api\V2\CustomerController')->only('show');

    Route::apiResource('general-settings', 'Api\V2\GeneralSettingController')->only('index');

    Route::apiResource('home-categories', 'Api\V2\HomeCategoryController')->only('index');

    //Route::get('purchase-history/{id}', 'Api\V2\PurchaseHistoryController@index')->middleware('auth:api');
    //Route::get('purchase-history-details/{id}', 'Api\V2\PurchaseHistoryDetailController@index')->name('purchaseHistory.details')->middleware('auth:api');

    Route::get('purchase-history/{id}', 'Api\V2\PurchaseHistoryController@index');
    Route::get('purchase-history-details/{id}', 'Api\V2\PurchaseHistoryController@details');
    Route::get('purchase-history-items/{id}', 'Api\V2\PurchaseHistoryController@items');

    Route::get('filter/categories', 'Api\V2\FilterController@categories');
    Route::get('filter/brands', 'Api\V2\FilterController@brands');

    Route::get('products/admin', 'Api\V2\ProductController@admin');
    Route::get('products/seller/{id}', 'Api\V2\ProductController@seller');
    Route::get('products/category/{id}', 'Api\V2\ProductController@category')->name('api.products.category');
    Route::get('products/sub-category/{id}', 'Api\V2\ProductController@subCategory')->name('products.subCategory');
    Route::get('products/sub-sub-category/{id}', 'Api\V2\ProductController@subSubCategory')->name('products.subSubCategory');
    Route::get('products/brand/{id}', 'Api\V2\ProductController@brand')->name('api.products.brand');
    Route::get('products/todays-deal', 'Api\V2\ProductController@todaysDeal');
    Route::get('products/featured', 'Api\V2\ProductController@featured');
    Route::get('products/best-seller', 'Api\V2\ProductController@bestSeller');
    Route::get('products/related/{id}', 'Api\ProductController@related')->name('products.related');

    Route::get('products/featured-from-seller/{id}', 'Api\V2\ProductController@newFromSeller')->name('products.featuredromSeller');
    Route::get('products/search', 'Api\V2\ProductController@search');
    Route::get('products/variant/price', 'Api\V2\ProductController@variantPrice');
    Route::get('products/home', 'Api\V2\ProductController@home');
    Route::apiResource('products', 'Api\V2\ProductController')->except(['store', 'update', 'destroy']);

    Route::get('cart-summary/{user_id}/{owner_id}', 'Api\V2\CartController@summary')->middleware('auth:api');
    Route::post('carts/process', 'Api\V2\CartController@process')->middleware('auth:api');

    Route::post('carts/add', 'Api\V2\CartController@add')->middleware('auth:api');
    Route::post('carts/change-quantity', 'Api\V2\CartController@changeQuantity')->middleware('auth:api');
    Route::apiResource('carts', 'Api\V2\CartController')->only('destroy')->middleware('auth:api');
    Route::post('carts/{user_id}', 'Api\V2\CartController@getList')->middleware('auth:api');


    Route::post('coupon-apply', 'Api\V2\CheckoutController@apply_coupon_code')->middleware('auth:api');
    Route::post('coupon-remove', 'Api\V2\CheckoutController@remove_coupon_code')->middleware('auth:api');

    Route::post('update-address-in-cart', 'Api\V2\AddressController@updateAddressInCart')->middleware('auth:api');

    Route::get('payment-types', 'Api\V2\PaymentTypesController@getList');

    Route::get('reviews/product/{id}', 'Api\V2\ReviewController@index')->name('api.reviews.index');
    Route::get('reviews/user', 'Api\ReviewController@userReview')->middleware('auth:api');
    Route::post('reviews/submit', 'Api\V2\ReviewController@submit')->middleware('auth:api');

    Route::get('shop/user/{id}', 'Api\V2\ShopController@shopOfUser')->middleware('auth:api');
    Route::get('shops/details/{id}', 'Api\V2\ShopController@info')->name('shops.info');
    Route::get('shops/products/all/{id}', 'Api\V2\ShopController@allProducts')->name('shops.allProducts');
    Route::get('shops/products/top/{id}', 'Api\V2\ShopController@topSellingProducts')->name('shops.topSellingProducts');
    Route::get('shops/products/featured/{id}', 'Api\V2\ShopController@featuredProducts')->name('shops.featuredProducts');
    Route::get('shops/products/new/{id}', 'Api\V2\ShopController@newProducts')->name('shops.newProducts');
    Route::get('shops/brands/{id}', 'Api\V2\ShopController@brands')->name('shops.brands');
    Route::apiResource('shops', 'Api\V2\ShopController')->only('index');

    Route::apiResource('sliders', 'Api\V2\SliderController')->only('index');

    Route::get('wishlists-check-product', 'Api\V2\WishlistController@isProductInWishlist')->middleware('auth:api');;
    Route::get('wishlists-add-product', 'Api\V2\WishlistController@add')->middleware('auth:api');;
    Route::get('wishlists-remove-product', 'Api\V2\WishlistController@remove')->middleware('auth:api');;
    Route::get('wishlists/{id}', 'Api\V2\WishlistController@index')->middleware('auth:api');;
    Route::apiResource('wishlists', 'Api\V2\WishlistController')->except(['index', 'update', 'show']);

    Route::apiResource('settings', 'Api\V2\SettingsController')->only('index');

    Route::get('policies/seller', 'Api\V2\PolicyController@sellerPolicy')->name('policies.seller');
    Route::get('policies/support', 'Api\V2\PolicyController@supportPolicy')->name('policies.support');
    Route::get('policies/return', 'Api\V2\PolicyController@returnPolicy')->name('policies.return');

    Route::get('user/info/{id}', 'Api\V2\UserController@info')->middleware('auth:api');
    Route::post('user/info/update', 'Api\V2\UserController@updateName')->middleware('auth:api');
    Route::get('user/shipping/address/{id}', 'Api\V2\AddressController@addresses')->middleware('auth:api');
    Route::post('user/shipping/create', 'Api\V2\AddressController@createShippingAddress')->middleware('auth:api');
    Route::post('user/shipping/update', 'Api\V2\AddressController@updateShippingAddress')->middleware('auth:api');
    Route::post('user/shipping/update-location', 'Api\V2\AddressController@updateShippingAddressLocation')->middleware('auth:api');
    Route::post('user/shipping/make_default', 'Api\V2\AddressController@makeShippingAddressDefault')->middleware('auth:api');
    Route::get('user/shipping/delete/{id}', 'Api\V2\AddressController@deleteShippingAddress')->middleware('auth:api');

    Route::post('get-user-by-access_token', 'Api\V2\UserController@getUserInfoByAccessToken');

    Route::get('cities', 'Api\V2\AddressController@getCities');
    Route::get('countries', 'Api\V2\AddressController@getCountries');

    Route::post('shipping_cost', 'Api\V2\ShippingController@shipping_cost')->middleware('auth:api');

    Route::post('coupon/apply', 'Api\V2\CouponController@apply')->middleware('auth:api');


    Route::any('stripe', 'Api\V2\StripeController@stripe');
    Route::any('/stripe/create-checkout-session', 'Api\V2\StripeController@create_checkout_session')->name('api.stripe.get_token');
    Route::any('/stripe/payment/callback', 'Api\V2\StripeController@callback')->name('api.stripe.callback');
    Route::any('/stripe/success', 'Api\V2\StripeController@success')->name('api.stripe.success');
    Route::any('/stripe/cancel', 'Api\V2\StripeController@cancel')->name('api.stripe.cancel');

    Route::any('paypal/payment/url', 'Api\V2\PaypalController@getUrl')->name('api.paypal.url');
    Route::any('paypal/payment/done', 'Api\V2\PaypalController@getDone')->name('api.paypal.done');
    Route::any('paypal/payment/cancel', 'Api\V2\PaypalController@getCancel')->name('api.paypal.cancel');

    Route::any('razorpay/pay-with-razorpay', 'Api\V2\RazorpayController@payWithRazorpay')->name('api.razorpay.payment');
    Route::any('razorpay/payment', 'Api\V2\RazorpayController@payment')->name('api.razorpay.payment');
    Route::post('razorpay/success', 'Api\V2\RazorpayController@success')->name('api.razorpay.success');

    Route::any('paystack/init', 'Api\V2\PaystackController@init')->name('api.paystack.init');
    Route::post('paystack/success', 'Api\V2\PaystackController@success')->name('api.paystack.success');

    Route::any('iyzico/init', 'Api\V2\IyzicoController@init')->name('api.iyzico.init');
    Route::any('iyzico/callback', 'Api\V2\IyzicoController@callback')->name('api.iyzico.callback');
    Route::post('iyzico/success', 'Api\V2\IyzicoController@success')->name('api.iyzico.success');

    Route::get('bkash/begin', 'Api\V2\BkashController@begin')->middleware('auth:api');
    Route::get('bkash/api/webpage/{token}/{amount}', 'Api\V2\BkashController@webpage')->name('api.bkash.webpage');
    Route::any('bkash/api/checkout/{token}/{amount}', 'Api\V2\BkashController@checkout')->name('api.bkash.checkout');
    Route::any('bkash/api/execute/{token}', 'Api\V2\BkashController@execute')->name('api.bkash.execute');
    Route::any('bkash/api/fail', 'Api\V2\BkashController@fail')->name('api.bkash.fail');
    Route::any('bkash/api/success', 'Api\V2\BkashController@success')->name('api.bkash.success');
    Route::post('bkash/api/process', 'Api\V2\BkashController@process')->name('api.bkash.process');

    Route::get('nagad/begin', 'Api\V2\NagadController@begin')->middleware('auth:api');
    Route::any('nagad/verify/{payment_type}', 'Api\V2\NagadController@verify')->name('app.nagad.callback_url');
    Route::post('nagad/process', 'Api\V2\NagadController@process');

    Route::get('sslcommerz/begin', 'Api\V2\SslCommerzController@begin');
    Route::post('sslcommerz/success', 'Api\V2\SslCommerzController@payment_success');
    Route::post('sslcommerz/fail', 'Api\V2\SslCommerzController@payment_fail');
    Route::post('sslcommerz/cancel', 'Api\V2\SslCommerzController@payment_cancel');

    Route::post('payments/pay/wallet', 'Api\V2\WalletController@processPayment')->middleware('auth:api');
    Route::post('payments/pay/cod', 'Api\V2\PaymentController@cashOnDelivery')->middleware('auth:api');

    Route::post('order/store', 'Api\V2\OrderController@store')->middleware('auth:api');
    Route::get('profile/counters/{user_id}', 'Api\V2\ProfileController@counters')->middleware('auth:api');
    Route::post('profile/update', 'Api\V2\ProfileController@update')->middleware('auth:api');
    Route::post('profile/update-device-token', 'Api\V2\ProfileController@update_device_token')->middleware('auth:api');
    Route::post('profile/update-image', 'Api\V2\ProfileController@updateImage')->middleware('auth:api');

    Route::get('wallet/balance/{id}', 'Api\V2\WalletController@balance')->middleware('auth:api');
    Route::get('wallet/history/{id}', 'Api\V2\WalletController@walletRechargeHistory')->middleware('auth:api');

    Route::get('flash-deals', 'Api\V2\FlashDealController@index');
    Route::get('flash-deal-products/{id}', 'Api\V2\FlashDealController@products');
    Route::post('/change-language', 'Api\LanguageController@changeLanguage');
    Route::get('/languages', 'Api\LanguageController@index');
    Route::get('/tranlate-type', 'Api\FrontendController@getMobile');
});

Route::fallback(function() {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});
