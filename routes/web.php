<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MealCategoriesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantsController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('rest_list', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [RestaurantsController::class, 'showAll'])->name('rest_all');
Route::get('/search', [RestaurantsController::class, 'showAll'])->name('rest_all');
Route::get('/restaurants/{name}', [MealCategoriesController::class, 'showAll'])->name('restContent');
Route::post('/search', [RestaurantsController::class, 'search'])->name('search');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'profile_info'])->name('dashboard');

Route::middleware(['auth', 'profile_info'])->group(function (){
    Route::get('/cart', [CartController::class, 'cart'])->name('cart');
    Route::get('/placeOrder', [OrdersController::class, 'placeOrder'])->name('placeOrder');
    Route::post('/addToCart', [OrdersController::class, 'addToCart'])->name('addToCart');
    Route::post('/increase', [OrdersController::class, 'increase'])->name('increase');
    Route::post('/decrease', [OrdersController::class, 'decrease'])->name('decrease');
    Route::post('/removeFromCart', [OrdersController::class, 'removeFromCart'])->name('removeFromCart');
    Route::get('/my_orders', [OrdersController::class, 'ordersList'])->name('my_orders');
    Route::get('/orders/{id}', [OrdersController::class, 'viewOrder'])->name('viewOrder');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/personal_information', function () {
        return Inertia::render('Profile/PersonalInfo');
    })->name('fillInfo');

    Route::post('/personal_information', [ProfileController::class, 'fillInfo'])->name('fillInfo');
});

require __DIR__.'/auth.php';
