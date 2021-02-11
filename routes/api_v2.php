<?php

use \App\Http\Controllers\Api\V2\HomePageController;
// use Illuminate\Routing\Route;

Route::prefix('v2')->group(function () {
    // Route::get('banners', 'Api\V2\HomePageController@banners');
    Route::match(['get', 'post'], 'banners', [HomePageController::class, 'banners']);
});
