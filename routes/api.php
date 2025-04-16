<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\doctor\AuthController;
use App\Http\Controllers\api\doctor\invoiceController;
use App\Http\Controllers\api\doctor\paymentController;
use App\Http\Controllers\api\doctor\SurgeryController;

Route::prefix('doctor')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/surgeries/list', [SurgeryController::class, 'list']);
        Route::get('/surgery/{id}', [SurgeryController::class, 'show']);
        Route::get('/invoices', [invoiceController::class, 'index']);
        Route::get('/payments', [paymentController::class, 'index']);
    });
});
