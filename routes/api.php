<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Landing\HeroController;
use App\Http\Controllers\Landing\SectionController;
use App\Http\Controllers\Landing\EducationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth.role:admin,user'])->group(function () {
    Route::post('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

Route::middleware(['auth.role:admin'])->group(function () {
    Route::get('heroes', [HeroController::class, 'index']);
    Route::post('heroes', [HeroController::class, 'store']);

    Route::get('section', [SectionController::class, 'index']);
    Route::get('section/{id}', [SectionController::class, 'show']);
    Route::post('section/{id?}', [SectionController::class, 'store']);

    Route::get('education', [EducationController::class, 'index']);
    Route::get('education/{id}', [EducationController::class, 'show']);
    Route::post('education/{id?}', [EducationController::class, 'store']);
});