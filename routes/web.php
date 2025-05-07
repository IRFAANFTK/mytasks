<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('edit');
Route::get('/users/create', [UserController::class, 'create'])->name('create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');


