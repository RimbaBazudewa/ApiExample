<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PemainController;
use App\Http\Controllers\Api\PertandinganController;
use App\Http\Controllers\Api\TimController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\FuncCall;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::post("logout", 'logout');
    });
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::controller(TimController::class)->prefix('tim')->name('tim.')->group(function () {
        Route::post("store", "store")->name('store');
        Route::put("update/{id}", "update")->name('update');
        Route::delete("destroy/{id}", "destroy")->name('destroy');
    });
    Route::apiResource('pemain', PemainController::class);
    Route::apiResource('pertandingan', PertandinganController::class);
});
Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register')->name('register');
});
