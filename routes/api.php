<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/category', [CategoryController::class, 'findAllCategory']);
Route::get('/category/{id}', [CategoryController::class, 'findById']);
Route::post('/category', [CategoryController::class, 'createCategory']);
Route::post('/category/{id}', [CategoryController::class, 'updateCategory']);
Route::delete('/category/{id}', [CategoryController::class, 'deleteCategory']);

Route::get('/product', [ProductController::class, 'findAllProduct']);
Route::get('/product/{id}', [ProductController::class, 'findById']);
Route::post('/product', [ProductController::class, 'createProduct']);
Route::post('/product/{id}', [ProductController::class, 'updateProduct']);
Route::delete('/product/{id}', [ProductController::class, 'deleteProduct']);

Route::get('/category-product', [CategoryProductController::class, 'findAllCategoryProduct']);
Route::get('/category-product/{categoryId}', [CategoryProductController::class, 'findByCategoryProduct']);
Route::post('/category-product', [CategoryProductController::class, 'createCategoryProduct']);
Route::post('/category-product/{id}', [CategoryProductController::class, 'updateCategoryProduct']);
Route::delete('/category-product/{id}', [CategoryProductController::class, 'deleteCategoryProduct']);
