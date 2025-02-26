<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Panel\DoctorRoleController;
use App\Http\Controllers\Panel\SpecialityController;
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
        Route::get('/Delete{id}', [UserController::class, "Delete"])->name('DeleteUser');
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
        Route::get('/Delete{id}', [SpecialityController::class, "Delete"])->name('Delete.Speciality');
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
        Route::get('/Delete{id}', [DoctorRoleController::class, "Delete"])->name('DoctorRole.Delete');
    });
});
