<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\MataKuliahController;
use App\Http\Controllers\Api\V1\ProgramStudiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('v1.')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login')->middleware('throttle:5,1');
    Route::get('program-studi', [ProgramStudiController::class, 'index'])->name('program-studi.index');
    Route::apiResource('mata-kuliah', MataKuliahController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
