<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Doctor\AuthController;
use App\Http\Controllers\Api\Doctor\InvoiceController;
use App\Http\Controllers\Api\Doctor\PaymentController;
use App\Http\Controllers\Api\Doctor\SurgeryController;

Route::prefix('doctor')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/surgeries/list', [SurgeryController::class, 'list']);
        Route::get('/surgery/{id}', [SurgeryController::class, 'show']);
        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::get('/payments', [PaymentController::class, 'index']);
    });
});
