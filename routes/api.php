<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\FilterCategoryController;
use App\Http\Controllers\MatelController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductMasterController;
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

Route::post('/productmaster', [ProductMasterController::class, 'product']);
Route::post('/productcategory', [ProductCategoryController::class, 'category']);
Route::post('/categoryproduct', [CategoryProductController::class, 'categoryproduct']);
Route::post('/categorylist', [CategoryProductController::class, 'categorylist']);
Route::post('/metal', [MatelController::class, 'metal']);
