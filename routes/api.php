<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\RequestDownloadForm;
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

Route::get('/products', [ProductController::class, 'index']);

Route::get('products/{product}', [ProductController::class, 'show']);

Route::get('/recipes_by_moments', [RecipeController::class, 'getByMoment']);

Route::post('/request-download', [RequestDownloadForm::class, 'store']);
// Route::post('/request-download/test', [RequestDownloadForm::class, 'store_test']);
