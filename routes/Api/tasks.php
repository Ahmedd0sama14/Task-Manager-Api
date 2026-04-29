<?php
use Illuminate\Support\Facades\Route;


/********** Auth Routes **********/
use App\Http\Controllers\Api\TaskController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('tasks/search',[TaskController::class ,'search'])->name('tasks.search');
    Route::apiResource('tasks', TaskController::class);
});
