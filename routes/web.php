<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/stripe-payment', [StripeController::class, 'showPaymentForm'])->name('stripe.payment.form');
Route::post('/stripe-payment', [StripeController::class, 'handlePayment'])->name('stripe.payment');
Route::post('/stripe-webhook', [StripeController::class, 'handleWebhook'])->name('stripe.webhook');


Route::post('/add-product', [ProductController::class, 'addProduct']);
Route::get('/getproduct',[ProductController::class,'getProduct']);
Route::get('/user/{id}',[UserController::class,'show']);
Route::get('/Age/{age}',[UserController::class,'Age'])->middleware('checkage');
Route::get('/getproduct/price-greater-than/{price}',[ProductController::class,'getProductByPrice'])->middleware('authcustom');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
