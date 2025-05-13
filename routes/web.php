<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/edit/{user}', [UserController::class, 'edit'])->name('edit');
Route::get('/users/create', [UserController::class, 'create'])->name('create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
Route::get('/users/show/{id}', [UserController::class, 'show'])->name('users.show');
Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.delete');





Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
Route::get('/departments/show/{id}', [DepartmentController::class, 'show'])->name('departments.show');
Route::get('/departments/edit/{department}', [DepartmentController::class, 'edit'])->name('departments.edit');
Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
Route::post('/departments/store', [DepartmentController::class, 'store'])->name('departments.store');
Route::post('/departments/update', [DepartmentController::class, 'update'])->name('departments.update');
Route::delete('/departments/delete/{id}', [DepartmentController::class, 'destroy'])->name('departments.delete');





Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/show/{id}', [TaskController::class, 'show'])->name('tasks.show');
Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->name('tasks.edit');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
Route::post('/tasks/update', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/delete/{id}', [TaskController::class, 'destroy'])->name('tasks.delete');


});



