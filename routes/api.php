<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\MockSlackAPI;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BurritoController;

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

Route::resource( 'user', UserController::class )
    ->except( [
        'create',
        'show',
        'edit'
    ] );

Route::resource( 'event', EventController::class )
    ->except( [
        'create',
        'show',
        'edit'
    ] );

Route::post('/burrito', [BurritoController::class, 'slackChallenge']);

Route::get( '/slack', function() {
    echo 'Hello';
} );

Route::prefix( 'slack' )->group( function() {

    Route::get( '/', function() {
        echo 'Hello';
    } );

    Route::get( 'event/{eventType}', [
        MockSlackAPI::class,
        'event'
    ] );

    Route::get( 'users.list', [
        MockSlackAPI::class,
        'users_list'
    ] );

} );
