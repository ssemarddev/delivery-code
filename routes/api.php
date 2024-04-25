<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', [AuthController::class, 'authenticate']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('categories', CategoryController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::delete('/categories', [CategoryController::class, 'destroy']);

    Route::resource('products', ProductController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::delete('/products', [ProductController::class, 'destroy']);

    Route::resource('users', UserController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::delete('/users', [UserController::class, 'destroy']);

    Route::resource('cities', CityController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::delete('/cities', [CityController::class, 'destroy']);

    Route::resource('clients', ClientController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::delete('/clients', [ClientController::class, 'destroy']);

    Route::get('/orders/page/{page}', [OrderController::class, 'last']);
    Route::resource('orders', OrderController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::delete('/orders', [OrderController::class, 'destroy']);
    Route::put('/orders/{id}/Pendiente', [OrderController::class, 'status']);
    Route::put('/orders/{id}/Listo', [OrderController::class, 'ready']);
    Route::put('/orders/{id}/Entregado', [OrderController::class, 'deliver']);
    Route::put('/orders/{id}/Cancelado', [OrderController::class, 'cancel']);
    Route::put('/orders/{id}/charge', [OrderController::class, 'charge']);

    Route::resource('providers', ProviderController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::delete('/providers', [ProviderController::class, 'destroy']);

    Route::resource('purchases', PurchaseController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::delete('/purchases', [PurchaseController::class, 'destroy']);

    Route::resource('funds', FundController::class)->only([
        'index', 'store', 'update'
    ]);
    Route::put('/funds/open/{id}', [FundController::class, 'open']);
    Route::delete('/funds', [FundController::class, 'destroy']);

    Route::resource('withdrawals', WithdrawalController::class)->only([
        'index', 'store'
    ]);
});

Route::get('/order/{id}', [ReportController::class, 'order']);
Route::get('/delivery/order/{ids}/{user}', [ReportController::class, 'delivery']);
Route::get('/store/order/{ids}/{user}', [ReportController::class, 'store']);
// Route::get('/orders/{id}/{user}', [ReportController::class, 'orders']);
Route::get('/seller/order/{ids}/{user}', [ReportController::class, 'seller']);
Route::get('/purchases/{ids}/{user}', [ReportController::class, 'purchase']);
