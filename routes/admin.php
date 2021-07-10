<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/update', 'UpdateController@step0')->name('update');
Route::get('/update/step1', 'UpdateController@step1')->name('update.step1');
Route::get('/update/step2', 'UpdateController@step2')->name('update.step2');

Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['auth', 'admin']);
Route::group(['prefix' =>'admin', 'middleware' => ['auth', 'admin']], function(){
	//Update Routes

	Route::resource('categories','CategoryController');
	Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');
	Route::get('/categories/destroy/{id}', 'CategoryController@destroy')->name('categories.destroy');
	Route::post('/categories/featured', 'CategoryController@updateFeatured')->name('categories.featured');

	Route::resource('brands','BrandController');
	Route::get('/brands/edit/{id}', 'BrandController@edit')->name('brands.edit');
	Route::get('/brands/destroy/{id}', 'BrandController@destroy')->name('brands.destroy');

	Route::post('/products/seller/featured', 'SellerProductController@updateSellerFeatured')->name('products.seller.featured');

    Route::post('/products/store/','ProductController@store')->name('products.store');
	Route::post('/products/update/{id}','ProductController@update')->name('products.update');
	Route::get('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
    Route::get('/products/make_combination', 'ProductController@make_combination')->name('products.make_combination');
	Route::post('/products/published', 'ProductController@updatePublished')->name('products.published');
	Route::post('/products/accepted', 'ProductController@updateAccepted')->name('products.accepted');
	Route::post('/products/publisheds', 'ProductController@updatePublisheds')->name('products.publisheds');
	Route::get('/products/admin','ProductController@admin_products')->name('products.admin');
	Route::get('/products/seller','ProductController@seller_products')->name('products.seller');
	Route::get('/products/all','ProductController@all_products')->name('products.all');
	Route::get('/products/manage','ProductController@manageProducts')->name('products.manage');
	Route::get('/products/manage/{id}/accept','ProductController@changeOnModerationAccept')->name('products.manage.change.accept');
	Route::get('/products/manage/{id}/refuse','ProductController@changeOnModerationRefuse')->name('products.manage.change.refuse');
	Route::get('/products/create','ProductController@create')->name('products.create');
	Route::get('/products/admin/edit/{id}','ProductController@admin_product_edit')->name('products.admin.edit');
	Route::get('/products/seller/edit/{id}','ProductController@seller_product_edit')->name('products.seller.edit');
    Route::post('/products/todays_deal', 'ProductController@updateTodaysDeal')->name('products.todays_deal');
    Route::post('/products/todays_deals', 'ProductController@updateTodaysDeals')->name('products.todays_deals');
    Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');
    Route::post('/products/featureds', 'ProductController@updateFeatureds')->name('products.featureds');
    Route::post('/products/get_products_by_subcategory', 'ProductController@get_products_by_subcategory')->name('products.get_products_by_subcategory');

	Route::post('/elements/update/{id}','ElementController@update')->name('elements.update');
	Route::get('/elements/destroy/{id}', 'ElementController@destroy')->name('elements.destroy');
    Route::get('/elements/variation/remove','ElementController@remove_variation')->name('elements.variation.remove');
    Route::get('/elements/admin','ElementController@elementsIndex')->name('elements.admin');
	Route::get('/elements/seller','ElementController@elementsIndex')->name('elements.seller');
	Route::get('/elements/all','ElementController@elementsIndex')->name('elements.all');
	Route::get('/elements/manage','ElementController@manageElements')->name('elements.manage');
	Route::get('/elements/manage/{id}/accept','ElementController@changeOnModerationAccept')->name('elements.manage.change.accept');
	Route::get('/elements/manage/{id}/refuse','ElementController@changeOnModerationRefuse')->name('elements.manage.change.refuse');
    Route::get('/elements/create','ElementController@create')->name('elements.create');
    Route::post('/elements/store','ElementController@store')->name('elements.store');
	Route::get('/elements/admin/{id}/edit','ElementController@admin_element_edit')->name('elements.admin.edit');
	Route::get('/elements/seller/{id}/edit','ElementController@seller_element_edit')->name('elements.seller.edit');
	Route::post('/elements/todays_deal', 'ElementController@updateTodaysDeal')->name('elements.todays_deal');
	Route::post('/elements/featured', 'ElementController@updateFeatured')->name('elements.featured');
    Route::get('/elements/make_selected_attribute_options', 'ElementController@make_selected_attribute_options')->name('elements.make_selected_attribute_options');
    Route::get('/elements/make_attribute_options', 'ElementController@make_attribute_options')->name('elements.make_attribute_options');
    Route::get('/elements/make_color_options', 'ElementController@make_color_options')->name('elements.make_color_options');
    Route::get('/elements/make_attribute_variations', 'ElementController@make_attribute_variations')->name('elements.make_attribute_variations');
    Route::get('/elements/make_all_combination', 'ElementController@make_all_combination')->name('elements.make_all_combination');
    Route::get('/element/products', 'ElementController@elementProducts')->name('element.products.edit');
    Route::get('/element/index', 'ElementController@elementsIndex')->name('elements.index');
	Route::post('/elements/accepted', 'ElementController@updateAccepted')->name('elements.accepted');

    // Route::get('/elements/make_choice_options', 'ElementController@make_choice_options')->name('elements.make_choice_options');
    // Route::post('/elements/make_choice_options', 'ElementController@make_choice_options')->name('elements.make_choice_options');
	Route::post('/elements/published', 'ElementController@updatePublished')->name('elements.published');

	Route::resource('sellers','SellerController');
	Route::get('sellers_ban/{id}','SellerController@ban')->name('sellers.ban');
	Route::get('/sellers/destroy/{id}', 'SellerController@destroy')->name('sellers.destroy');
	Route::get('/sellers/view/{id}/verification', 'SellerController@show_verification_request')->name('sellers.show_verification_request');
	Route::get('/sellers/approve/{id}', 'SellerController@approve_seller')->name('sellers.approve');
	Route::get('/sellers/reject/{id}', 'SellerController@reject_seller')->name('sellers.reject');
	Route::get('/sellers/login/{id}', 'SellerController@login')->name('sellers.login');
	Route::post('/sellers/payment_modal', 'SellerController@payment_modal')->name('sellers.payment_modal');
	Route::get('/seller/payments', 'PaymentController@payment_histories')->name('sellers.payment_histories');
	Route::get('/seller/payments/show/{id}', 'PaymentController@show')->name('sellers.payment_history');

	Route::resource('customers','CustomerController');
	Route::get('customers_ban/{customer}','CustomerController@ban')->name('customers.ban');
	Route::get('/customers/login/{id}', 'CustomerController@login')->name('customers.login');
	Route::get('/customers/destroy/{id}', 'CustomerController@destroy')->name('customers.destroy');

	Route::get('/newsletter', 'NewsletterController@index')->name('newsletters.index');
	Route::post('/newsletter/send', 'NewsletterController@send')->name('newsletters.send');
	Route::post('/newsletter/test/smtp', 'NewsletterController@testEmail')->name('test.smtp');

	Route::resource('profile','ProfileController');

	Route::post('/business-settings/update', 'BusinessSettingsController@update')->name('business_settings.update');
	Route::post('/business-settings/update/activation', 'BusinessSettingsController@updateActivationSettings')->name('business_settings.update.activation');
	Route::get('/general-setting', 'BusinessSettingsController@general_setting')->name('general_setting.index');
	Route::get('/activation', 'BusinessSettingsController@activation')->name('activation.index');
	Route::get('/payment-method', 'BusinessSettingsController@payment_method')->name('payment_method.index');
	Route::get('/file_system', 'BusinessSettingsController@file_system')->name('file_system.index');
	Route::get('/social-login', 'BusinessSettingsController@social_login')->name('social_login.index');
	Route::get('/smtp-settings', 'BusinessSettingsController@smtp_settings')->name('smtp_settings.index');
	Route::get('/google-analytics', 'BusinessSettingsController@google_analytics')->name('google_analytics.index');
	Route::get('/google-recaptcha', 'BusinessSettingsController@google_recaptcha')->name('google_recaptcha.index');
	Route::get('/facebook-chat', 'BusinessSettingsController@facebook_chat')->name('facebook_chat.index');
	Route::post('/env_key_update', 'BusinessSettingsController@env_key_update')->name('env_key_update.update');
	Route::post('/payment_method_update', 'BusinessSettingsController@payment_method_update')->name('payment_method.update');
	Route::post('/google_analytics', 'BusinessSettingsController@google_analytics_update')->name('google_analytics.update');
	Route::post('/google_recaptcha', 'BusinessSettingsController@google_recaptcha_update')->name('google_recaptcha.update');
	Route::post('/facebook_chat', 'BusinessSettingsController@facebook_chat_update')->name('facebook_chat.update');
	Route::post('/facebook_pixel', 'BusinessSettingsController@facebook_pixel_update')->name('facebook_pixel.update');
	Route::get('/currency', 'CurrencyController@currency')->name('currency.index');
    Route::post('/currency/update', 'CurrencyController@updateCurrency')->name('currency.update');
    Route::post('/your-currency/update', 'CurrencyController@updateYourCurrency')->name('your_currency.update');
	Route::get('/currency/create', 'CurrencyController@create')->name('currency.create');
	Route::post('/currency/store', 'CurrencyController@store')->name('currency.store');
	Route::post('/currency/currency_edit', 'CurrencyController@edit')->name('currency.edit');
	Route::post('/currency/update_status', 'CurrencyController@update_status')->name('currency.update_status');
	Route::get('/verification/form', 'BusinessSettingsController@seller_verification_form')->name('seller_verification_form.index');
	Route::post('/verification/form', 'BusinessSettingsController@seller_verification_form_update')->name('seller_verification_form.update');
	Route::get('/vendor_commission', 'BusinessSettingsController@vendor_commission')->name('business_settings.vendor_commission');
	Route::post('/vendor_commission_update', 'BusinessSettingsController@vendor_commission_update')->name('business_settings.vendor_commission.update');

	Route::resource('/languages', 'LanguageController');
	Route::post('/languages/{id}/update', 'LanguageController@update')->name('languages.update');
	Route::get('/languages/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy');
	Route::post('/languages/update_rtl_status', 'LanguageController@update_rtl_status')->name('languages.update_rtl_status');
	Route::post('/languages/key_value_store', 'LanguageController@key_value_store')->name('languages.key_value_store');
	Route::get('/translations/show_translation', 'LanguageController@show_translation')->name('translations.show_translation');
	// Route::get('/translations/show_category_translations', 'LanguageController@show_category_translations')->name('translations.show_category_translations');
	// Route::get('/translations/show_product_translations', 'LanguageController@show_product_translations')->name('translations.show_product_translations');
	Route::post('/translations/key_value_store_translations', 'LanguageController@key_value_store_translations')->name('translations.key_value_store_translations');
	// Route::post('/translations/select_translation_language', 'LanguageController@select_translation_language')->name('translations.select_translation_language');

	// website setting
	Route::group(['prefix' => 'website'], function(){
		Route::view('/header', 'backend.website_settings.header')->name('website.header');
		Route::view('/footer', 'backend.website_settings.footer')->name('website.footer');
		Route::view('/pages', 'backend.website_settings.pages.index')->name('website.pages');
		Route::view('/appearance', 'backend.website_settings.appearance')->name('website.appearance');
		Route::resource('custom-pages', 'PageController');
		Route::get('/custom-pages/edit/{id}', 'PageController@edit')->name('custom-pages.edit');
		Route::get('/custom-pages/destroy/{id}', 'PageController@destroy')->name('custom-pages.destroy');
	});

	Route::resource('roles','RoleController');
	Route::get('/roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
    Route::get('/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');

    Route::resource('staffs','StaffController');
    Route::get('/staffs/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy');

	Route::resource('flash_deals','FlashDealController');
	Route::get('/flash_deals/edit/{id}', 'FlashDealController@edit')->name('flash_deals.edit');
  	Route::get('/flash_deals/destroy/{id}', 'FlashDealController@destroy')->name('flash_deals.destroy');
	Route::post('/flash_deals/update_status', 'FlashDealController@update_status')->name('flash_deals.update_status');
	Route::post('/flash_deals/update_featured', 'FlashDealController@update_featured')->name('flash_deals.update_featured');
	Route::post('/flash_deals/product_discount', 'FlashDealController@product_discount')->name('flash_deals.product_discount');
	Route::post('/flash_deals/product_discount_edit', 'FlashDealController@product_discount_edit')->name('flash_deals.product_discount_edit');
	Route::get('/flash_deals/change/status/{id}', 'FlashDealController@changeStatus')->name('flash_deals.change_status');

	//Subscribers
	Route::get('/subscribers', 'SubscriberController@index')->name('subscribers.index');
	Route::get('/subscribers/destroy/{id}', 'SubscriberController@destroy')->name('subscriber.destroy');

	// Route::get('/orders', 'OrderController@admin_orders')->name('orders.index.admin');
	// Route::get('/orders/{id}/show', 'OrderController@show')->name('orders.show');
	// Route::get('/sales/{id}/show', 'OrderController@sales_show')->name('sales.show');
	// Route::get('/sales', 'OrderController@sales')->name('sales.index');

	// All Orders
	Route::get('/all_orders', 'OrderController@all_orders')->name('all_orders.index');
	Route::get('/all_orders/{id}/show', 'OrderController@all_orders_show')->name('all_orders.show');

	// Inhouse Orders
	Route::get('/inhouse-orders', 'OrderController@admin_orders')->name('inhouse_orders.index');
	Route::get('/inhouse-orders/{id}/show', 'OrderController@show')->name('inhouse_orders.show');

	// Seller Orders
	Route::get('/seller_orders', 'OrderController@seller_orders')->name('seller_orders.index');
	Route::get('/seller_orders/{id}/show', 'OrderController@seller_orders_show')->name('seller_orders.show');

	// Pickup point orders
	Route::get('orders_by_pickup_point','OrderController@pickup_point_order_index')->name('pick_up_point.order_index');
	Route::get('/orders_by_pickup_point/{id}/show', 'OrderController@pickup_point_order_sales_show')->name('pick_up_point.order_show');

	Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
	Route::get('invoice/admin/{order_id}', 'InvoiceController@admin_invoice_download')->name('admin.invoice.download');

	Route::post('/pay_to_seller', 'CommissionController@pay_to_seller')->name('commissions.pay_to_seller');

	//Reports
	Route::get('/stock_report', 'ReportController@stock_report')->name('stock_report.index');
	Route::get('/in_house_sale_report', 'ReportController@in_house_sale_report')->name('in_house_sale_report.index');
	Route::get('/seller_sale_report', 'ReportController@seller_sale_report')->name('seller_sale_report.index');
	Route::get('/wish_report', 'ReportController@wish_report')->name('wish_report.index');
	Route::get('/user_search_report', 'ReportController@user_search_report')->name('user_search_report.index');

	//Coupons
	Route::resource('coupon','CouponController');
	Route::post('/coupon/get_form', 'CouponController@get_coupon_form')->name('coupon.get_coupon_form');
	Route::post('/coupon/get_form_edit', 'CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
	Route::get('/coupon/destroy/{id}', 'CouponController@destroy')->name('coupon.destroy');

	//Reviews
	Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
    Route::post('/reviews/published', 'ReviewController@updatePublished')->name('reviews.published');
//    Route::post('/reviews/publisheds', 'ReviewController@updatePublisheds')->name('reviews.publisheds');

	//Support_Ticket
	Route::get('support_ticket/','SupportTicketController@admin_index')->name('support_ticket.admin_index');
	Route::get('support_ticket/{id}/show','SupportTicketController@admin_show')->name('support_ticket.admin_show');
	Route::post('support_ticket/reply','SupportTicketController@admin_store')->name('support_ticket.admin_store');

	//Pickup_Points
	Route::resource('pick_up_points','PickupPointController');
	Route::get('/pick_up_points/edit/{id}', 'PickupPointController@edit')->name('pick_up_points.edit');
	Route::get('/pick_up_points/destroy/{id}', 'PickupPointController@destroy')->name('pick_up_points.destroy');

	//conversation of seller customer
	Route::get('conversations','ConversationController@admin_index')->name('conversations.admin_index');
    Route::get('conversation/found_it_cheaper','ConversationController@found_it_cheaper')->name('conversations.found_it_cheaper');
    Route::get('conversation/price_reduction','ConversationController@price_reduction')->name('conversation.price_reduction');
    Route::get('conversation/report_description','ConversationController@report_description')->name('conversation.report_description');

	Route::get('conversations/{id}/show','ConversationController@admin_show')->name('conversations.admin_show');

    Route::post('/sellers/profile_modal', 'SellerController@profile_modal')->name('sellers.profile_modal');
    Route::post('/sellers/approved', 'SellerController@updateApproved')->name('sellers.approved');

//	Route::resource('branches','BranchController');
    Route::get('/branches', 'BranchController@index')->name('branches.index');
    Route::get('/branches/edit/{id}', 'BranchController@edit')->name('branches.edit');
    Route::get('/branches/attributes/{id}', 'BranchController@arribute_index')->name('branches.arributes');
    Route::post('/branches/{id}/update/attributes', 'BranchController@updateAttributes')->name('branches.update.arributes');
    Route::get('/branches/destroy/{id}', 'BranchController@destroy')->name('branches.destroy');
	Route::post('/branches/{id}/update','BranchController@update')->name('branches.update');
    Route::post('/branches/store','BranchController@store')->name('branches.store');
	// Route::resource('product-attribute-sets','ProductAttributeSetController');
//	Route::post('product-attributes/add/attr','ProductAttributeController@createAttr')->name('product-attributes.add_attr');
//	Route::get('product-attributes/{id}/attr/edit','ProductAttributeController@editAttr')->name('product-attributes.edit_attr');
//	Route::post('product-attributes/{id}/attr/edit','ProductAttributeController@editAttr')->name('product-attributes.edit_attr');
//	Route::patch('product-attributes/{id}/attr/update','ProductAttributeController@updateAttr')->name('product-attributes.update_attr');
//	Route::delete('product-attributes/{id}/attr/destoy','ProductAttributeController@destroyAttr')->name('product-attributes.destroy_attr');
//	Route::post('product-attributes/{id}/change/categories','ProductAttributeController@changeCategories')->name('product-attributes.change_categories');

	Route::resource('attributes','AttributeController');
//	Route::get('/attributes/edit/{id}', 'AttributeController@edit')->name('attributes.edit');
    Route::post('/attributes/{id}/update','AttributeController@update')->name('attributes.update');
	Route::get('/attributes/destroy/{id}', 'AttributeController@destroy')->name('attributes.destroy');
//    Route::post('attributes/{id}/update/categories','AttributeController@updateCategories')->name('attributes.update.categories');
//    Route::get('attributes/edit/categories/{id}','AttributeController@editCategories')->name('attributes.edit.categories');
    Route::post('attributes/edit/characteristics','AttributeController@updateCharacteristics')->name('attributes.edit.characteristics');
    Route::get('attributes/edit/characteristics','AttributeController@editCharacteristics')->name('attributes.edit.characteristics');
    Route::post('attributes/update/combination','AttributeController@update_combination_status')->name('attributes.combination');
//
    Route::resource('addons','AddonController');
	Route::post('/addons/activation', 'AddonController@activation')->name('addons.activation');

	Route::get('/customer-bulk-upload/index', 'CustomerBulkUploadController@index')->name('customer_bulk_upload.index');
	Route::post('/bulk-user-upload', 'CustomerBulkUploadController@user_bulk_upload')->name('bulk_user_upload');
	Route::post('/bulk-customer-upload', 'CustomerBulkUploadController@customer_bulk_file')->name('bulk_customer_upload');
	Route::get('/user', 'CustomerBulkUploadController@pdf_download_user')->name('pdf.download_user');
	//Customer Package

	Route::resource('customer_packages','CustomerPackageController');
	Route::get('/customer_packages/edit/{id}', 'CustomerPackageController@edit')->name('customer_packages.edit');
	Route::get('/customer_packages/destroy/{id}', 'CustomerPackageController@destroy')->name('customer_packages.destroy');

	//Classified Products
	Route::get('/classified_products', 'CustomerProductController@customer_product_index')->name('classified_products');
	Route::post('/classified_products/published', 'CustomerProductController@updatePublished')->name('classified_products.published');

	//Shipping Configuration
	Route::get('/shipping_configuration', 'BusinessSettingsController@shipping_configuration')->name('shipping_configuration.index');
	Route::post('/shipping_configuration/update', 'BusinessSettingsController@shipping_configuration_update')->name('shipping_configuration.update');

	// Route::resource('pages', 'PageController');
	// Route::get('/pages/destroy/{id}', 'PageController@destroy')->name('pages.destroy');

	Route::resource('countries','CountryController');
	Route::post('/countries/status', 'CountryController@updateStatus')->name('countries.status');

	Route::resource('cities', 'CityController');
	Route::get('/cities/edit/{id}', 'CityController@edit')->name('cities.edit');
	Route::get('/cities/destroy/{id}', 'CityController@destroy')->name('cities.destroy');

	Route::view('/system/update', 'backend.system.update')->name('system_update');
	Route::view('/system/server-status', 'backend.system.server_status')->name('system_server');

	// uploaded files
	Route::any('/uploaded-files/file-info', 'AizUploadController@file_info')->name('uploaded-files.info');
	Route::resource('/uploaded-files', 'AizUploadController');
	Route::get('/uploaded-files/destroy/{id}', 'AizUploadController@destroy')->name('uploaded-files.destroy');


	Route::get('products/product_warehouse/{id}', 'ProductController@productWarehouseData');
	Route::resource('warehouse', 'WarehouseController')->except([
		'create'
	]);
	Route::post('importwarehouse', 'WarehouseController@importWarehouse')->name('warehouse.import');
	Route::post('warehouse/deletebyselection', 'WarehouseController@deleteBySelection');
	Route::get('warehouse/lims_warehouse_search', 'WarehouseController@limsWarehouseSearch')->name('warehouse.search');
});
