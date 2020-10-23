<?php

use App\Http\Controllers\ApiAuthController;
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
});
