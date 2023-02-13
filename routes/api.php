<?php

use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\SignUpController;
use App\Http\Controllers\Api\v1\Banner\BannerSliderController;
use App\Http\Controllers\Api\v1\Brand\BrandController;
use App\Http\Controllers\Api\v1\Cart\CartController;
use App\Http\Controllers\Api\v1\Category\CategoryController;
use App\Http\Controllers\Api\v1\Product\FeaturedProductController;
use App\Http\Controllers\Api\v1\Product\ProductController;
use App\Http\Controllers\Api\v1\User\UserController;
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

    Route::post('register',[SignUpController::class,'register']);
    Route::post('login',[LoginController::class,'login']);

    Route::group(['prefix'=>'user'], function () {
        Route::group(['middleware' => 'auth:api'], function () {
            Route::get('getUser/{id}', [UserController::class, 'getUser']);
            Route::post('delete', [UserController::class, 'delete']);
        });
    });



    Route::group(['prefix' => 'product'], function () {
        Route::get('getProducts',[ProductController::class,'getProducts']);
        Route::get('search',[ProductController::class,'searchProduct']);
        Route::get('getTrashedProducts',[ProductController::class,'getTrashedProducts']);
        Route::get('getProduct/{id}',[ProductController::class,'getProduct']);
        Route::put('updateProduct',[ProductController::class,'updateProduct']);
        Route::delete('softDeleteProduct/{id}',[ProductController::class,'softDeleteProduct']);
        Route::post('restoreProduct',[ProductController::class,'restoreProduct']);
        Route::delete('destroy/{id}',[ProductController::class,'destroy']);

        Route::get('featuredProduct',[FeaturedProductController::class,'getFeaturedProducts']);
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

    Route::group(['prefix'=>'cart'],function () {
        Route::get('getUserCart/{id}',[CartController::class,'getUserCart']);
        Route::post('addToCart',[CartController::class,'addToCart']);
        Route::put('update',[CartController::class,'update']);
        Route::delete('delete',[CartController::class,'delete']);
        Route::delete('checkout',[CartController::class,'checkout']);
    });


});



