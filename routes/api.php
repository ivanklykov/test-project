<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(ProductController::class)->group(function () {
    Route::get('/V1/product', 'index');
    Route::get('/V1/product/{id}', 'show');
    Route::post('/V1/product', 'store');
    Route::put('/V1/product/{id}', 'update');
    Route::patch('/V1/product/{id}/archive', 'archive');
    Route::delete('/V1/product/{id}', 'destroy');
});

Route::controller(CategoryController::class)->group(function () {
    Route::post('/V1/category', 'store');
    Route::delete('/V1/category/{id}', 'destroy');
});