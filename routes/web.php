<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Panel\DoctorController;
use App\Http\Controllers\Panel\DoctorRoleController;
use App\Http\Controllers\Panel\InsuranceController;
use App\Http\Controllers\Panel\OperationsController;
use App\Http\Controllers\Panel\SpecialityController;
use App\Http\Controllers\Panel\SurgeryController;
use App\Http\Controllers\Panel\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Panel.index');
})->name('Panel');

Route::namespace('Auth')->group(function () {
    //login form
    Route::get('/Login', [AuthController::class, "LoginForm"])->name('LoginForm');
    //login
    Route::post('/Login', [AuthController::class, "Login"])->name('Login');
    // Route::get('/logout', [AuthController::class, "Logout"])->name('Logout');
});
Route::prefix('Panel')->group(function () {

    Route::prefix('User')->group(function () {
        //Users list
        Route::get('/List', [UserController::class, "Users"])->name('Show.Users');
        //show add user page
        Route::get('/Create', [UserController::class, "Create"])->name('User.Create.Form');
        //add User
        Route::post('/Create', [UserController::class, "Store"])->name('User.Store');
        //User edit page
        Route::get('/Edit{id}', [UserController::class, "Edit"])->name('EditUser');
        //User edit
        Route::post('/Edit{id}', [UserController::class, "Update"])->name('UpdateUser');
        //User delete
        Route::delete('/Delete{id}', [UserController::class, "Delete"])->name('DeleteUser');
    });
    Route::prefix('Speciality')->group(function () {
        //list
        Route::get('/List', [SpecialityController::class, "List"])->name('Show.Speciality');
        //show add page
        Route::get('/Create', [SpecialityController::class, "Create"])->name('Speciality.Create.Form');
        //add Speciality
        Route::post('/Create', [SpecialityController::class, "Store"])->name('Speciality.Store');
        //Speciality edit page
        Route::get('/Edit{id}', [SpecialityController::class, "Edit"])->name('Speciality.Edit');
        //Speciality edit
        Route::post('/Edit{id}', [SpecialityController::class, "Update"])->name('Update.Speciality');
        //Speciality delete
        Route::delete('/Delete{id}', [SpecialityController::class, "Delete"])->name('Delete.Speciality');
    });
    Route::prefix('DoctorRole')->group(function () {
        //list
        Route::get('/List', [DoctorRoleController::class, "List"])->name('Show.DoctorRole');
        //show add page
        Route::get('/Create', [DoctorRoleController::class, "Create"])->name('DoctorRole.Create');
        //add Speciality
        Route::post('/Create', [DoctorRoleController::class, "Store"])->name('DoctorRole.Store');
        //Speciality edit page
        Route::get('/Edit{id}', [DoctorRoleController::class, "Edit"])->name('DoctorRole.Edit');
        //Speciality edit
        Route::post('/Edit{id}', [DoctorRoleController::class, "Update"])->name('DoctorRole.Update');
        //Speciality delete
        Route::delete('/Delete{id}', [DoctorRoleController::class, "Delete"])->name('DoctorRole.Delete');
    });
    Route::prefix('Doctor')->group(function () {

        Route::get('/List', [DoctorController::class, "List"])->name('Doctors');
        Route::get('/Create', [DoctorController::class, "Create"])->name('Doctor.Create');
        Route::post('/Create', [DoctorController::class, "Store"])->name('Doctor.Store');
        Route::get('/Edit{id}', [DoctorController::class, "Edit"])->name('Doctor.Edit');
        Route::post('/Edit{id}', [DoctorController::class, "Update"])->name('Doctor.Update');
        Route::delete('/Delete{id}', [DoctorController::class, "Delete"])->name('Doctor.Delete');
    });
    Route::prefix('Insurances')->group(function () {
        Route::get('/List', [InsuranceController::class, 'List'])->name('insurances');
        Route::get('/create', [InsuranceController::class, 'create'])->name('insurances.create');
        Route::post('/store', [InsuranceController::class, 'store'])->name('insurances.store');
        Route::get('/edit/{id}', [InsuranceController::class, 'edit'])->name('insurances.edit');
        Route::post('/update/{id}', [InsuranceController::class, 'update'])->name('insurances.update');
        Route::delete('/delete/{id}', [InsuranceController::class, 'delete'])->name('insurances.delete');
    });
    Route::prefix('operations')->group(function () {
        Route::get('/List', [OperationsController::class, 'List'])->name('operations');
        Route::get('/create', [OperationsController::class, 'create'])->name('operations.create');
        Route::post('/store', [OperationsController::class, 'store'])->name('operations.store');
        Route::get('/edit/{id}', [OperationsController::class, 'edit'])->name('operations.edit');
        Route::post('/update/{id}', [OperationsController::class, 'update'])->name('operations.update');
        Route::delete('/delete/{id}', [OperationsController::class, 'delete'])->name('operations.delete');
    });
    Route::prefix('Insurances')->group(function () {
        Route::get('/List', [InsuranceController::class, 'List'])->name('insurances');
        Route::get('/create', [InsuranceController::class, 'create'])->name('insurances.create');
        Route::post('/store', [InsuranceController::class, 'store'])->name('insurances.store');
        Route::get('/edit/{id}', [InsuranceController::class, 'edit'])->name('insurances.edit');
        Route::post('/update/{id}', [InsuranceController::class, 'update'])->name('insurances.update');
        Route::delete('/delete/{id}', [InsuranceController::class, 'delete'])->name('insurances.delete');
    });
    Route::prefix('surgery')->group(function () {
        Route::get('/List', [SurgeryController::class, 'List'])->name('surgeries');
        Route::get('/create', [SurgeryController::class, 'create'])->name('surgery.create');
        Route::post('/store', [SurgeryController::class, 'store'])->name('surgery.store');
        Route::get('/edit/{id}', [SurgeryController::class, 'edit'])->name('surgery.edit');
        Route::post('/update/{id}', [SurgeryController::class, 'update'])->name('surgery.update');
        Route::delete('/delete/{id}', [SurgeryController::class, 'delete'])->name('surgery.delete');
    });
});
