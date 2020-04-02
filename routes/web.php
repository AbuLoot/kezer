<?php

// Authentication routes...
Route::get('cs-login', 'Auth\AuthCustomController@getLogin')->middleware('guest');;
Route::post('cs-login', 'Auth\AuthCustomController@postLogin');

// Registration routes...
Route::get('cs-register', 'Auth\AuthCustomController@getRegister')->middleware('guest');;
Route::post('cs-register', 'Auth\AuthCustomController@postRegister');
// Route::get('confirm/{token}', 'Auth\AuthCustomController@confirm');

Auth::routes();

// Route::get('opt', 'TranslateController@options');
// Route::get('cat', 'TranslateController@categories');
// Route::get('pro', 'TranslateController@products');
// Route::get('parsing', 'ParsingController@index');
// Route::get('request', 'ParsingController@request');

// User Profile
Route::group(['middleware' => 'auth', 'role:user'], function() {

    Route::get('profile', 'ProfileController@profile');
    Route::get('profile/edit', 'ProfileController@editProfile');
    Route::post('profile', 'ProfileController@updateProfile');
    Route::get('orders', 'ProfileController@myOrders');
});


// Joystick Administration
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {

    Route::get('/', 'Joystick\AdminController@index');
    Route::get('filemanager', 'Joystick\AdminController@filemanager');
    Route::get('frame-filemanager', 'Joystick\AdminController@frameFilemanager');

    Route::get('translate', 'Joystick\ProductController@translate');

    Route::resource('categories', 'Joystick\CategoryController');
    Route::get('categories-actions', 'Joystick\CategoryController@actionCategories');
    Route::resource('countries', 'Joystick\CountryController');
    Route::resource('companies', 'Joystick\CompanyController');
    Route::get('companies-actions', 'Joystick\CompanyController@actionCompanies');
    Route::resource('cities', 'Joystick\CityController');
    Route::resource('news', 'Joystick\NewsController');
    Route::resource('languages', 'Joystick\LanguageController');
    Route::resource('modes', 'Joystick\ModeController');
    Route::resource('options', 'Joystick\OptionController');
    Route::resource('orders', 'Joystick\OrderController');
    Route::resource('pages', 'Joystick\PageController');
    Route::resource('section', 'Joystick\SectionController');
    Route::resource('projects', 'Joystick\ProjectController');
    Route::resource('products', 'Joystick\ProductController');
    Route::resource('slide', 'Joystick\SlideController');
    Route::get('products/{id}/comments', 'Joystick\ProductController@comments');
    Route::get('products/{id}/destroy-comment', 'Joystick\ProductController@destroyComment');
    Route::get('products-search', 'Joystick\ProductController@search');
    Route::get('products-category/{id}', 'Joystick\ProductController@categoryProducts');
    Route::get('products-actions', 'Joystick\ProductController@actionProducts');

    Route::resource('roles', 'Joystick\RoleController');
    Route::resource('users', 'Joystick\UserController');
    Route::resource('permissions', 'Joystick\PermissionController');

    Route::get('apps', 'Joystick\AppController@index');
    Route::get('apps/{id}', 'Joystick\AppController@show');
    Route::delete('apps/{id}', 'Joystick\AppController@destroy');
});


// Input
Route::get('search', 'InputController@search');
Route::get('search-ajax', 'InputController@searchAjax');
Route::post('filter-products', 'InputController@filterProducts');
Route::post('send-app', 'InputController@sendApp');


// Shop
Route::get('/', 'ShopController@index');
Route::get('catalog', 'ShopController@catalog');
Route::get('catalog/all/{category}', 'ShopController@allCategoryProducts');
Route::get('catalog/{category}/{id}', 'ShopController@categoryProducts');
Route::get('catalog/{category}/{subcategory}/{id}', 'ShopController@subCategoryProducts');
Route::get('catalog/brand/{company}', 'ShopController@brandProducts');
Route::get('p/{product}', 'ShopController@product');
Route::post('comment-product', 'ShopController@saveComment');


// Cart Actions
Route::get('cart', 'CartController@cart');
Route::get('add-to-cart/{id}', 'CartController@addToCart');
Route::get('remove-from-cart/{id}', 'CartController@removeFromCart');
Route::get('clear-cart', 'CartController@clearCart');
Route::post('store-order', 'CartController@storeOrder');
Route::get('destroy-from-cart/{id}', 'CartController@destroy');


// Favourite Actions
Route::get('favorite', 'FavouriteController@getFavorite');
Route::get('toggle-favourite/{id}', 'FavouriteController@toggleFavourite');


// News
Route::get('news', 'NewsController@news');
Route::get('news-category/{page}', 'NewsController@newsCategory');
Route::get('news/{page}', 'NewsController@newsSingle');
Route::post('comment-news', 'NewsController@saveComment');


// Pages
Route::get('contacts', 'PageController@contacts');
Route::get('{page}', 'PageController@page');
