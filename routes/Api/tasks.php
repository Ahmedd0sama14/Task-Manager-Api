<?php
use Illuminate\Support\Facades\Route;


/********** Auth Routes **********/
use App\Http\Controllers\Api\TaskController;


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});
