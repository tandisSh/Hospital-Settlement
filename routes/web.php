<?php

use App\Http\Controllers\Auth\AuthController;
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
        //show add user page
        Route::get('/Create', [UserController::class, "Create"])->name('User.Create.Form');
        //add User
        Route::post('/Create', [UserController::class, "Store"])->name('User.Store');
        //Users list
        Route::get('/List', [UserController::class, "Users"])->name('Show.Users');
        //User edit page
        Route::get('/Edit', [UserController::class, "EditUser"])->name('EditUser');
        //User edit
        // Route::post('/Edit{id}', [UserController::class, "UpdateUser"])->name('UpdateUser');
        //User delete
        // Route::get('/Delete{id}', [UserController::class, "DeleteUser"])->name('DeleteUser');
    });
    // Route::prefix('Speciality')->group(function () {
    //     //show add user page
    //     Route::get('/Create', [SpecialityController::class, "Create"])->name('Speciality.Create.Form');
    //     //add User
    //     // Route::post('/Create', [UserController::class, "Store"])->name('User.Store');
    //     //Users list
    //     Route::get('/List', [SpecialityController::class, "List"])->name('Show.Speciality');
    //     //User edit page
    //     Route::get('/Edit', [SpecialityController::class, "Edit"])->name('EditSpeciality');
    //     //User edit
    //     // Route::post('/Edit{id}', [UserController::class, "UpdateUser"])->name('UpdateUser');
    //     //User delete
    //     // Route::get('/Delete{id}', [UserController::class, "DeleteUser"])->name('DeleteUser');
    // });
});
