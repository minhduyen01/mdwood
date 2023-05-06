<?php

use Illuminate\Http\Request;
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

Route::group(['namespace' => 'Api\Page'], function () {
    Route::get('top_product', 'ProductController@GetTopProduct');
    Route::get('new_product', 'ProductController@GetNewProducts');
    Route::get('product/{slug}', 'ProductController@GetDetailProduct');
    Route::get('random/product', 'ProductController@GetRandom');
    Route::get('product', 'ProductController@GetProducts');
    Route::get('news', 'NewsController@getNewList');
    Route::get('news/{slug}', 'NewsController@getDetail');
    Route::get('all_news', 'NewsController@getAll');

    Route::get('slide', 'HomeController@slide');
    Route::get('category', 'HomeController@category');
    Route::get('type', 'HomeController@type');

    Route::post('login', 'AuthenticateController@login');
    Route::post('register','AuthenticateController@register');

    Route::middleware(['auth'])->group(function () {
        Route::get('user', 'AuthenticateController@me');
        Route::post('logout', 'AuthenticateController@logout');
        Route::post('refresh', 'AuthenticateController@refresh');
        Route::post('user/{id}', 'AuthenticateController@update');
        Route::get('user/order', 'AuthenticateController@order');
        Route::get('user/order/{order_no}', 'AuthenticateController@orderDetail');
        Route::post('change_password', 'AuthenticateController@changePassword');
        Route::post('user/bill/{id}', 'AuthenticateController@updateOrder');

        Route::post('checkout', 'CartController@payment');
    });
});

Route::group(['prefix' => 'admin', 'namespace' => 'Api\Admin'], function () {
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::resource('product', 'ProductController');
        Route::post('product/sale', 'ProductController@addSale');

        Route::get('type_product', 'TypeProductController@getAll');
        Route::post('type_product', 'TypeProductController@store');
        Route::get('type_product/{id}', 'TypeProductController@show');
        Route::post('type_product/{id}', 'TypeProductController@update');
        Route::delete('type_product/{id}', 'TypeProductController@destroy');

        Route::get('supplier', 'SupplierController@getAll');
        Route::delete('supplier/{id}', 'SupplierController@destroy');
        Route::post('supplier', 'SupplierController@store');
        Route::get('supplier/{id}', 'SupplierController@show');
        Route::post('supplier/{id}', 'SupplierController@update');

        Route::get('category', 'CategoryController@getAll');
        Route::delete('category/{id}', 'CategoryController@destroy');
        Route::post('category', 'CategoryController@store');
        Route::get('category/{id}', 'CategoryController@show');
        Route::post('category/{id}', 'CategoryController@update');

        Route::get('slide', 'SlideController@index');
        Route::post('slide', 'SlideController@store');
        Route::get('slide/{id}', 'SlideController@show');
        Route::post('slide/{id}', 'SlideController@update');
        Route::delete('slide/{id}', 'SlideController@destroy');

        Route::get('bill', 'OrderController@index');
        Route::post('bill/{id}', 'OrderController@update');
        Route::get('bill/{id}', 'OrderController@detail');

        Route::post('news', 'NewsController@create');
        Route::get('news', 'NewsController@getList');
        Route::post('news/{id}', 'NewsController@update');
        Route::get('news/{id}', 'NewsController@detail');

        Route::get('order_on_day', 'AdminController@countOrderOnDay');
        Route::get('register_on_day', 'AdminController@countUserRegisterOnDay');
        Route::get('revenue_of_day', 'AdminController@revenueOfDay');
        Route::get('revenue_of_week', 'AdminController@revenueOfWeek');
        Route::get('revenue_of_month', 'AdminController@revenueOfMonth');
        Route::get('top_product_sale', 'AdminController@topProductSale');
    });

    Route::post('upload', 'UploadController@upload');
});
