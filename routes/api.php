<?php

use App\Http\Controllers\Api\v1\Banner\BannerSliderController;
use App\Http\Controllers\Api\v1\Brand\BrandController;
use App\Http\Controllers\Api\v1\Category\CategoryController;
use App\Http\Controllers\Api\v1\Product\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'product'], function () {
        Route::get('getProducts',[ProductController::class,'getProducts']);
        Route::get('getTrashedProducts',[ProductController::class,'getTrashedProducts']);
        Route::get('getProduct/{id}',[ProductController::class,'getProduct']);
        Route::put('updateProduct',[ProductController::class,'updateProduct']);
        Route::delete('softDeleteProduct/{id}',[ProductController::class,'softDeleteProduct']);
        Route::post('restoreProduct',[ProductController::class,'restoreProduct']);
        Route::delete('destroy/{id}',[ProductController::class,'destroy']);
    });

    Route::group(['prefix' => 'category'], function () {
        Route::get('getCategories',[CategoryController::class,'getCategories']);
    });

    Route::group(['prefix'=>'brand'],function () {
        Route::get('getBrands',[BrandController::class,'getBrands']);
    });

    Route::group(['prefix'=>'banner'],function () {
        Route::get('getHomeBannerSlider',[BannerSliderController::class,'getHomeBannerSlider']);
    });
});



