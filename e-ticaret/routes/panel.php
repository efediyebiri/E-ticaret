<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\IsAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AboutController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\DashboardController;


Route::group(['middleware' => 'panelsetting', 'prefix' => 'panel', 'as' => 'panel.'], function(){     //prefix ne ile başlayacağını söyler.

    Route::get('/',[DashboardController::class , "index"])->name("giris.index");

    Route::get('/slider',[SliderController::class , "index"])->name("slider.index");
    Route::get('/slider/ekle',[SliderController::class , "create"])->name("slider.create");
    Route::get('/slider/{id}/edit',[SliderController::class , "edit"])->name("slider.edit");
    Route::post('/slider/store',[SliderController::class , "store"])->name("slider.store");
    Route::put('/slider/{id}/update',[SliderController::class , "update"])->name("slider.update");
    Route::delete('/slider/destroy',[SliderController::class , "destroy"])->name("slider.destroy");
    Route::post('/slider-durum/update',[SliderController::class , "status"])->name("slider.status");


    Route::resource('/category', CategoryController::class)->except('destroy');
    Route::get('/category/{id}/edit',[CategoryController::class , "edit"])->name("category.edit");
    Route::delete('/category/destroy' , [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::post('/category-durum/update',[CategoryController::class , "status"])->name("category.status");
    Route::post('/category/create',[CategoryController::class , "create"])->name("category.create");


    Route::get('/about',[AboutController::class , "index"])->name("about.index");
    Route::post('/about/update',[AboutController::class , "update"])->name("about.update");


    Route::get('/contact',[ContactController::class , "index"])->name("contact.index");
    Route::get('/contact/{id}/edit',[ContactController::class , "edit"])->name("contact.edit");
    Route::put('/contact/{id}/update',[ContactController::class , "update"])->name("contact.update");
    Route::delete('/contact/destroy' , [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::post('/contact-durum/update',[ContactController::class , "status"])->name("contact.status");

    Route::get('/setting',[SettingController::class , "index"])->name("setting.index");
    Route::get('/setting/create',[SettingController::class , "create"])->name("setting.create");
    Route::post('/setting/store',[SettingController::class , "store"])->name("setting.store");
    Route::get('/setting/{id}/edit',[SettingController::class , "edit"])->name("setting.edit");
    Route::put('/setting/{id}/update',[SettingController::class , "update"])->name("setting.update");
    Route::delete('/setting/destroy' , [SettingController::class, 'destroy'])->name('setting.destroy');

    Route::resource('/product', ProductController::class)->except('destroy');
    Route::delete('/product/destroy' , [ProductController::class, 'destroy'])->name('product.destroy');
    Route::post('/product-durum/update',[ProductController::class , "status"])->name("product.status");
    Route::post('/product/create',[ProductController::class , "create"])->name("product.create");

    Route::get('/order',[OrderController::class , "index"])->name("order.index");
    Route::get('/order/{id}/edit',[OrderController::class , "edit"])->name("order.edit");
    Route::put('/order/{id}/update',[OrderController::class , "update"])->name("order.update");
    Route::delete('/order/destroy' , [OrderController::class, 'destroy'])->name('order.destroy');
    Route::post('/order-durum/update',[OrderController::class , "status"])->name("order.status");

    Route::resource('/users', UserController::class)->except('destroy');
    Route::delete('/users/destroy' , [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users-durum/update',[UserController::class , "status"])->name("users.status");
    Route::post('/users/create',[UserController::class , "create"])->name("users.create");

});
