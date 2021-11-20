<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventsOrganizerController;
use App\Http\Controllers\EventsPicturesController;
use App\Http\Controllers\PicturesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GeneralController;
use Illuminate\Routing\Router;

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

Route::get('/',  [GeneralController::class, 'index']);

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware(['apiJWT'])->group(function () {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::get('/refresh', [AuthController::class, 'refresh']);
    });
});

Route::group(['prefix' => 'events'], function () {
    Route::get('/{event}',  [GeneralController::class, 'show']);
    Route::middleware(['apiJWT'])->group(function () {
        Route::post('/',  [GeneralController::class, 'store']);
        Route::put('/{event}',  [GeneralController::class, 'update']);
        Route::delete('/{event}',  [GeneralController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'users'], function () {
    Route::post('/',  [UsersController::class, 'store']);
    Route::middleware(['apiJWT'])->group(function () {
        Route::get('/myprofile', [UsersController::class, 'myProfile']);
        Route::put('/myprofile',  [UsersController::class, 'update']);
    });
});

Route::group(['prefix' => 'pictures'], function () {
    Route::get('/{id}',  [EventsPicturesController::class, 'show']);
    Route::middleware(['apiJWT'])->group(function () {
        Route::put('/{id}',  [EventsPicturesController::class, 'update']);
        Route::delete('/{id}',  [EventsPicturesController::class, 'destroy']);
    });
});
