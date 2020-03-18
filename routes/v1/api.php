<?php

use App\Models\Store;
use App\User;
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


Route::group(['namespace' => 'API\V1'], function () {

/*
 |--------------------------------------------------------------------------
 | auth router
 |--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth',
        'namespace' => 'Auth'
    ], function ($router) {
        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
        $router->get('refresh', 'AuthController@refresh');
        $router->get('logout', 'AuthController@logout');
        $router->get('user', 'AuthController@getAuthenticatedUser');
    });

/*
 |--------------------------------------------------------------------------
 | customer router
 |--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'api',
        'prefix' => 'customer',
        'namespace' => 'Customer'
    ], function ($router) {
        $router->post('products', 'ProductController@index');
        $router->middleware(['auth:api'])->post('buy', 'OrderController@buy');
    });

/*
 |--------------------------------------------------------------------------
 | administrator router
 |--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'auth.role:admin',
        'prefix' => 'admin',
        'namespace' => 'Admin'
    ], function ($router) {
        $router->post('sellers', 'SellerController@create');
    });

/*
 |--------------------------------------------------------------------------
 | seller router
 |--------------------------------------------------------------------------
*/
    Route::group([
        'middleware' => 'auth.role:admin,seller',
        'prefix' => 'seller',
        'namespace' => 'Seller'
    ], function ($router) {
        $router->middleware(['store'])->post('products', 'ProductController');
        $router->put('stores', 'StoreController@update');
    });

});


Route::get('test', function () {

    dd($user);
});
