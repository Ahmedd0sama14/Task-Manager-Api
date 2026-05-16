<?php

use Illuminate\Support\Facades\Route;


/********** Auth Routes **********/

use App\Http\Controllers\Api\UserNotificationController;


Route::middleware('auth:sanctum')->prefix('user/notifications')->controller(UserNotificationController::class)->group(function () {
    Route::get('', 'index');
    Route::get('/unread', 'unread');
    Route::post('/ReadAll', 'markAllAsRead');
    Route::patch('{id}/read', 'markAsRead');
    Route::delete('/{id}', 'destroy');
});
