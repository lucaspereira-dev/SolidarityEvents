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

Route::get('/', function () {
    return 'Bem-vindo a API';
});

Route::group(['prefix' => 'events'], function () {
    Route::get('/',  [GeneralController::class, 'index']);
    Route::post('/{users}',  [GeneralController::class, 'store']);
    // Route::get('/{events}',  [EventsController::class, 'show']);
    Route::put('/{users}/{events}',  [GeneralController::class, 'update']);
    // Route::delete('/{events}',  [EventsController::class, 'destroy']);
});

// Route::group(['prefix' => 'eventsorganizer'], function () {
//     Route::get('/',  [EventsOrganizerController::class, 'index']);
//     Route::post('/',  [EventsOrganizerController::class, 'store']);
//     Route::get('/{eventsorganizer}',  [EventsOrganizerController::class, 'show']);
//     Route::put('/{eventsorganizer}',  [EventsOrganizerController::class, 'update']);
//     Route::delete('/{eventsorganizer}',  [EventsOrganizerController::class, 'destroy']);
// });

// Route::group(['prefix' => 'eventspictures'], function () {
//     Route::get('/',  [EventsPicturesController::class, 'index']);
//     Route::post('/',  [EventsPicturesController::class, 'store']);
//     Route::get('/{eventspictures}',  [EventsPicturesController::class, 'show']);
//     Route::put('/{eventspictures}',  [EventsPicturesController::class, 'update']);
//     Route::delete('/{eventspictures}',  [EventsPicturesController::class, 'destroy']);
// });

// Route::group(['prefix' => 'pictures'], function () {
//     Route::get('/',  [PicturesController::class, 'index']);
//     Route::post('/',  [PicturesController::class, 'store']);
//     Route::get('/{pictures}',  [PicturesController::class, 'show']);
//     Route::put('/{pictures}',  [PicturesController::class, 'update']);
//     Route::delete('/{pictures}',  [PicturesController::class, 'destroy']);
// });

Route::group(['prefix' => 'users'], function () {
    Route::get('/',  [UsersController::class, 'index']);
    Route::post('/',  [UsersController::class, 'store']);
    Route::get('/{users}',  [UsersController::class, 'show']);
    Route::put('/{users}',  [UsersController::class, 'update']);
    Route::delete('/{users}',  [UsersController::class, 'destroy']);
});

// Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
//     Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
// });
