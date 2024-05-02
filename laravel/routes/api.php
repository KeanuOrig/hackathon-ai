<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Maintenance\ProductController;
use App\Http\Controllers\Maintenance\UserController;
use App\Http\Controllers\Process\GeminiController;
use App\Http\Controllers\Auth\GoogleController;

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

// Normal Login
Route::get('google/login', [GoogleController::class, 'redirectToGoogle']);
Route::get('google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Gemini
Route::get('gemini/model', [GeminiController::class, 'listModel']);
Route::post('gemini/model', [GeminiController::class, 'createModel']);

Route::get('gemini/system/{id}', [GeminiController::class, 'showSystem']);
Route::get('gemini/system', [GeminiController::class, 'listSystem']);
Route::post('gemini/system', [GeminiController::class, 'createSystem']);

Route::post('gemini/chat', [GeminiController::class, 'chat']);
