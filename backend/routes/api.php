<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\TransactionController;
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

// Authentication
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login',    [ApiAuthController::class, 'login']);

Route::middleware('auth:api')->group(function() {
    Route::get( '/info',   [ApiAuthController::class, 'get_user']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    // Categories
    Route::get(   '/categories',       [CategoryController::class, 'getCategories']);
    Route::get(   '/categories/{id}',  [CategoryController::class, 'getCategories'])->where('id', '[0-9]+');
    Route::post(  '/categories',       [CategoryController::class, 'newCategory']);
    Route::patch( '/categories/{id}',  [CategoryController::class, 'modifyCategory'])->where('id', '[0-9]+');
    Route::delete('/categories/{id?}', [CategoryController::class, 'deleteCategory'])->where('id', '[0-9]+');

    // Transactions
    Route::get(    '/transactions',                       [TransactionController::class, 'getTransaction']);
    Route::get(    '/transactions/{id}',                  [TransactionController::class, 'getTransaction'])->where('id', '[0-9]+');
    Route::post(   '/transactions',                       [TransactionController::class, 'createTransaction']);
    Route::patch(  '/transactions/{id}',                  [TransactionController::class, 'modifyTransaction']);
    Route::delete( '/transactions/{id?}',                 [TransactionController::class, 'deleteTransaction'])->where('id', '[0-9]+');
    Route::post(   '/transactions/{id}/categories/{ct}',  [TransactionController::class, 'addCategoryToTransaction'])->where('id', '[0-9]+')->where('ct', '[0-9]+');
    Route::delete( '/transactions/{id}/categories/{ct?}', [TransactionController::class, 'removeCategoryFromTransaction'])->where('id', '[0-9]+')->where('ct', '[0-9]+');

    // Investments
    Route::get(    '/investments',          [InvestmentController::class, 'getInvestment']);
    Route::get(    '/investments/{id}',     [InvestmentController::class, 'getInvestmentById'])->where('id', '[0-9]+');
    Route::get(    '/investments/{symbol}', [InvestmentController::class, 'getInvestmentBySymbol']);
    Route::post(   '/investments',          [InvestmentController::class, 'createInvestment']);
    Route::patch(  '/investments/{id}',     [InvestmentController::class, 'updateInvestment'])->where('id', '[0-9]+');
    Route::delete( '/investments/{id}',     [InvestmentController::class, 'deleteInvestment'])->where('id', '[0-9]+');

    // Shares
    Route::get( '/shares',             [ShareController::class, 'getShare']);
    Route::get( '/shares/{symbol}',    [ShareController::class, 'getShare']);
    Route::put( '/shares/{symbol}',    [ShareController::class, 'createOrUpdateShare']);
});
