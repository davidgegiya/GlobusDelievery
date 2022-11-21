<?php

use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\MealCategoriesController;
use \App\Http\Controllers\RegistrationController;
use \App\Http\Controllers\OrdersController;
use \App\Http\Controllers\CartController;
use \App\Http\Controllers\LoginController;
use \App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('user.')->group(function (){
    Route::get('/restaurants', [RestaurantsController::class, 'showAll'])->name('showRestaurants');
    Route::get('/restaurants/{name}', [MealCategoriesController::class, 'showAll'])->name('restContent');
    Route::view('/profile', 'user.profile')->middleware('auth')->name('profile');
    Route::get('/orders/{id}', [OrdersController::class, 'viewOrder'])->middleware('auth')->name('viewOrder');
    Route::post('/search', [RestaurantsController::class, 'search'])->name('search');

    Route::post('/addToCart', [OrdersController::class, 'addToCart'])->middleware('auth')->name('addToCart');
    Route::post('/increase', [OrdersController::class, 'increase'])->middleware('auth')->name('increase');
    Route::post('/decrease', [OrdersController::class, 'decrease'])->middleware('auth')->name('decrease');
    Route::post('/getOrder', [OrdersController::class, 'getOrder'])->middleware('auth')->name('getOrder');
    Route::post('/removeFromCart', [OrdersController::class, 'removeFromCart'])->middleware('auth')->name('removeFromCart');

    Route::get('/cart', [CartController::class, 'cart'])->middleware('auth')->name('cart');
    Route::get('/cartRestLink', [CartController::class, 'cartRestLink'])->middleware('auth')->name('cartRestLink');
    Route::get('/placeOrder', [OrdersController::class, 'placeOrder'])->middleware('auth')->name('placeOrder');

    Route::get('/registration', function (){
        if(Auth::check()){
            return redirect(\route('user.profile'));
        }
        return view('authentication.registration');
    })->name('registration');
    Route::get('/login', function (){
        if(Auth::check()){
            return redirect(\route('user.profile'));
        }
        return view('authentication.login');
    })->name('login');
    Route::post('/registration', [RegistrationController::class, 'register']);
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
});
