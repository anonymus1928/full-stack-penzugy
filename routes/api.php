<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\InvestmentController;
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

// Login
Route::post('/login', [ApiAuthController::class, 'login']);

// Registration
Route::post('/register', [ApiAuthController::class, 'register']);

Route::middleware('auth:api')->group(function() {
    Route::get('/info', [ApiAuthController::class, 'get_user']);

    // Transactions
    Route::get(    '/transactions',        [TransactionController::class, 'getTransaction']);
    Route::get(    '/transactions/{id}',   [TransactionController::class, 'getTransaction'])->where('id', '[0-9]+');
    Route::post(   '/transactions/new',    [TransactionController::class, 'newTransaction']);
    Route::patch(  '/transactions/modify', [TransactionController::class, 'modifyTransaction']);
    Route::delete( '/transactions/delte',  [TransactionController::class, 'deleteTransaction']);

    // Investments
    Route::get(    '/investments',          [InvestmentController::class, 'getInvestment']);
    Route::get(    '/investments/get/{id}', [InvestmentController::class, 'getInvestment'])->where('id', '[0-9]+');
    Route::get(    '/investments/{symbol}', [InvestmentController::class, 'getInvestment']);
    Route::post(   '/investments/new',      [InvestmentController::class, 'newInvestment']);
    Route::patch(  '/investments/modify',   [InvestmentController::class, 'modifyInvestment']);
    Route::delete( '/investments/delte',    [InvestmentController::class, 'deleteInvestment']);

    // Shares
    Route::get( '/shares/{symbol}',    [ShareController::class, 'getShare']);
    Route::post( '/shares/{symbol}',   [ShareController::class, 'newShare']);
    Route::put( '/shares/{symbol}',    [ShareController::class, 'updateShare']);
});
