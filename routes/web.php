<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Homepage;

/*
|--------------------------------------------------------------------------
| Back Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('isLogin')->group(function(){
    Route::get('login','App\Http\Controllers\Back\AuthController@login')->name('login');
    Route::post('login','App\Http\Controllers\Back\AuthController@loginPost')->name('login.post');
});
Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
    Route::get('panel','App\Http\Controllers\Back\Dashboard@index')->name('dashboard');

    // MAKALE ROUTE
    Route::resource('articles','App\Http\Controllers\Back\ArticleController');
    Route::get('/switch','App\Http\Controllers\Back\ArticleController@switch')->name('switch');
    Route::get('/delete/{id}','App\Http\Controllers\Back\ArticleController@delete')->name('delete');
    Route::get('/hardDelete/{id}','App\Http\Controllers\Back\ArticleController@hardDelete')->name('hard-delete');
    Route::get('/deleted-articles','App\Http\Controllers\Back\ArticleController@trash')->name('trash');
    Route::get('/recycle/{id}','App\Http\Controllers\Back\ArticleController@recycle')->name('recycle');

    //KATEGORİ ROUTE

    Route::get('/categories','App\Http\Controllers\Back\CategoryController@index')->name('category.index');
    Route::get('/category/status','App\Http\Controllers\Back\CategoryController@switch')->name('category.switch');
    Route::post('/categories','App\Http\Controllers\Back\CategoryController@create')->name('category.create');
    
    Route::get('logout','App\Http\Controllers\Back\AuthController@logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
*/
Route::get('/','App\Http\Controllers\Front\Homepage@index')->name('homepage');
Route::get('sayfa','App\Http\Controllers\Front\Homepage@index');
Route::get('/category/{category}','App\Http\Controllers\Front\Homepage@category')->name('category');
Route::get('/{category}/{slug}','App\Http\Controllers\Front\Homepage@single')->name('single');
Route::get('/{safya}','App\Http\Controllers\Front\Homepage@page')->name('page');

