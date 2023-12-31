<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'address-book/'], function () {
        Route::get('list', [\App\Http\Controllers\AddressBookController::class, 'list']);
        Route::post('store', [\App\Http\Controllers\AddressBookController::class, 'store']);
        Route::post('delete', [\App\Http\Controllers\AddressBookController::class, 'delete']);
    });
});



