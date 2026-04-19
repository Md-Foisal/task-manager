<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\EnsureTaskIsNotCompleted;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::apiResource('tasks', TaskController::class)->except('update')->names('api.tasks');

    Route::match(['put', 'patch'], '/tasks/{task}', [TaskController::class, 'update'])->name('api.tasks.update')
    ->middleware(EnsureTaskIsNotCompleted::class);
});