<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\admin\DoctorController;
use App\Http\Controllers\admin\DoctorRoleController;
use App\Http\Controllers\admin\InsuranceController;
use App\Http\Controllers\admin\OperationsController;
use App\Http\Controllers\admin\SpecialityController;
use App\Http\Controllers\admin\SurgeryController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\InvoiceController;
use App\Http\Controllers\admin\PaymentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('admin.index');
})->name('admin');

Route::namespace('Auth')->group(function () {
    Route::get('/Login', [AuthController::class, "LoginForm"])->name('login');
    Route::post('/Login', [AuthController::class, "Login"])->name('Login');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::prefix('user')->group(function () {
        Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('editProfile');
        Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('updateProfile');
    });
    Route::prefix('speciality')->group(function () {
        //list
        Route::get('/list', [SpecialityController::class, "List"])->name('Show.Speciality');
        //show add page
        Route::get('/create', [SpecialityController::class, "Create"])->name('Speciality.Create.Form');
        //add Speciality
        Route::post('/create', [SpecialityController::class, "Store"])->name('Speciality.Store');
        //Speciality edit page
        Route::get('/edit{id}', [SpecialityController::class, "Edit"])->name('Speciality.Edit');
        //Speciality edit
        Route::post('/edit{id}', [SpecialityController::class, "Update"])->name('Update.Speciality');
        //Speciality delete
        Route::delete('/delete{id}', [SpecialityController::class, "Delete"])->name('Delete.Speciality');
    });
    Route::prefix('doctor-role')->group(function () {
        //list
        Route::get('/list', [DoctorRoleController::class, "List"])->name('Show.DoctorRole');
        //show add page
        Route::get('/create', [DoctorRoleController::class, "Create"])->name('DoctorRole.Create');
        //add Speciality
        Route::post('/create', [DoctorRoleController::class, "Store"])->name('DoctorRole.Store');
        //Speciality edit page
        Route::get('/edit{id}', [DoctorRoleController::class, "Edit"])->name('DoctorRole.Edit');
        //Speciality edit
        Route::post('/edit{id}', [DoctorRoleController::class, "Update"])->name('DoctorRole.Update');
        //Speciality delete
        Route::delete('/delete{id}', [DoctorRoleController::class, "Delete"])->name('DoctorRole.Delete');
    });
    Route::prefix('doctor')->group(function () {
        Route::get('/list', [DoctorController::class, "List"])->name('Doctors');
        Route::get('/show/{id}', [DoctorController::class, "Show"])->name('Doctor.Show');
        Route::get('/create', [DoctorController::class, "Create"])->name('Doctor.Create');
        Route::post('/create', [DoctorController::class, "Store"])->name('Doctor.Store');
        Route::get('/edit{id}', [DoctorController::class, "Edit"])->name('Doctor.Edit');
        Route::post('/edit{id}', [DoctorController::class, "Update"])->name('Doctor.Update');
        Route::delete('/delete{id}', [DoctorController::class, "Delete"])->name('Doctor.Delete');
    });
    Route::prefix('operations')->group(function () {
        Route::get('/list', [OperationsController::class, 'List'])->name('operations');
        Route::get('/create', [OperationsController::class, 'create'])->name('operations.create');
        Route::post('/store', [OperationsController::class, 'store'])->name('operations.store');
        Route::get('/edit/{id}', [OperationsController::class, 'edit'])->name('operations.edit');
        Route::post('/update/{id}', [OperationsController::class, 'update'])->name('operations.update');
        Route::delete('/delete/{id}', [OperationsController::class, 'delete'])->name('operations.delete');
    });
    Route::prefix('insurances')->group(function () {
        Route::get('/list', [InsuranceController::class, 'List'])->name('insurances');
        Route::get('/create', [InsuranceController::class, 'create'])->name('insurances.create');
        Route::post('/store', [InsuranceController::class, 'store'])->name('insurances.store');
        Route::get('/edit/{id}', [InsuranceController::class, 'edit'])->name('insurances.edit');
        Route::post('/update/{id}', [InsuranceController::class, 'update'])->name('insurances.update');
        Route::delete('/delete/{id}', [InsuranceController::class, 'delete'])->name('insurances.delete');
    });
    Route::prefix('surgery')->group(function () {
        Route::get('/list', [SurgeryController::class, 'List'])->name('surgeries');
        Route::get('/show/{id}', [SurgeryController::class, 'show'])->name('surgery.show');
        Route::get('/create', [SurgeryController::class, 'create'])->name('surgery.create');
        Route::post('/store', [SurgeryController::class, 'store'])->name('surgery.store');
        Route::get('/edit/{id}', [SurgeryController::class, 'edit'])->name('surgery.edit');
        Route::post('/update/{id}', [SurgeryController::class, 'update'])->name('surgery.update');
        Route::delete('/delete/{id}', [SurgeryController::class, 'delete'])->name('surgery.delete');
    });
    Route::prefix('invoice')->group(function () {
        Route::get('/invoice', [InvoiceController::class, 'index'])->name('admin.InvoiceList');
        Route::get('/pay', [InvoiceController::class, 'pay'])->name('admin.InvoicePay');
        Route::get('/search-pay', [InvoiceController::class, 'searchPay'])->name('admin.SearchInvoicePay');
        Route::post('/store', [InvoiceController::class, 'store'])->name('admin.StoreInvoice');
        Route::delete('/delete/{id}', [InvoiceController::class, 'destroy'])->name('admin.DeleteInvoice');
        Route::get('/invoices/print/{id}', [InvoiceController::class, 'print'])->name('admin.InvoicePrint');
    });
    Route::prefix('payment')->group(function () {
        Route::get('/create/{invoice}', [PaymentController::class, 'create'])->name('admin.Payment.Create');
        Route::post('/store', [PaymentController::class, 'storePayment'])->name('admin.StorePayment');
        Route::delete('/destroy/{id}', [PaymentController::class, 'destroy'])->name('admin.DestroyPayment');
        Route::get('/show/{id}', [PaymentController::class, 'show'])->name('admin.Payment.show');
    });
});
