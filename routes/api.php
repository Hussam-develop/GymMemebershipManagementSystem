<?php

use App\Http\Controllers\Api\V1\CheckinController;
use App\Http\Controllers\Api\V1\MemberController;
use App\Http\Controllers\Api\V1\PlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::prefix('v1')->group(function () {

    Route::apiResource('plans', PlanController::class);

    Route::prefix('members')->group(function () {
        Route::get('/', [MemberController::class, 'index']);
        Route::post('/', [MemberController::class, 'store']);
        Route::post('{member}/subscribe', [MemberController::class, 'subscribe']);
    });
    Route::post('checkins', [CheckinController::class, 'store'])->middleware('ensure.active.subscription');
});
