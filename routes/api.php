<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EventsOrganizerController;
use App\Http\Controllers\EventsPicturesController;
use App\Http\Controllers\PicturesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\UsersController;

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

Route::get('/', function(){
    return 'Bem-vindo a API';
});

Route::group(['prefix' =>'events'], function (){
    Route::get('/',  [EventsController::class, 'index']);
    Route::post('/',  [EventsController::class, 'store']);
    Route::get('/{event_id}',  [EventsController::class, 'show']);
    Route::put('/{event_id}',  [EventsController::class, 'update']);
    Route::delete('/{event_id}',  [EventsController::class, 'destroy']);
});

Route::group(['prefix' =>'eventsorganizer'], function (){
    Route::get('/',  [EventsOrganizerController::class, 'index']);
    Route::post('/',  [EventsOrganizerController::class, 'store']);
    Route::get('/{organizer_id}',  [EventsOrganizerController::class, 'show']);
    Route::put('/{organizer_id}',  [EventsOrganizerController::class, 'update']);
    Route::delete('/{organizer_id}',  [EventsOrganizerController::class, 'destroy']);
});

Route::group(['prefix' =>'eventspictures'], function (){
    Route::get('/',  [EventsPicturesController::class, 'index']);
    Route::post('/',  [EventsPicturesController::class, 'store']);
    Route::get('/{event_picture_id}',  [EventsPicturesController::class, 'show']);
    Route::put('/{event_picture_id}',  [EventsPicturesController::class, 'update']);
    Route::delete('/{event_picture_id}',  [EventsPicturesController::class, 'destroy']);
});

Route::group(['prefix' =>'pictures'], function (){
    Route::get('/',  [PicturesController::class, 'index']);
    Route::post('/',  [PicturesController::class, 'store']);
    Route::get('/{picture_id}',  [PicturesController::class, 'show']);
    Route::put('/{picture_id}',  [PicturesController::class, 'update']);
    Route::delete('/{picture_id}',  [PicturesController::class, 'destroy']);
});

Route::group(['prefix' =>'users'], function (){
    Route::get('/',  [UsersController::class, 'index']);
    Route::post('/',  [UsersController::class, 'store']);
    Route::get('/{user_id}',  [UsersController::class, 'show']);
    Route::put('/{user_id}',  [UsersController::class, 'update']);
    Route::delete('/{user_id}',  [UsersController::class, 'destroy']);
});

