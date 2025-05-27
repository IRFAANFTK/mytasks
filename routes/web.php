<?php

use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');
Route::get('/tasks/export-pdf', [App\Http\Controllers\TaskController::class, 'exportPdf'])->name('tasks.exportPdf');

Route::middleware('auth')->group(function () {

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/start/{task}', [TaskController::class, 'start'])->name('tasks.start');
    Route::get('/tasks/end/{task}', [TaskController::class, 'end'])->name('tasks.end');
    Route::get('/tasks/delete/{task}', [TaskController::class, 'delete'])->name('tasks.delete');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::get('/getTasks', [App\Http\Controllers\TaskController::class, 'getTasks'])->name('tasks.get');
    Route::get('/tasks/export', [TaskController::class, 'export'])->name('tasks.export');








    Route::resource('departments', DepartmentController::class);
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
    Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/departments/create', [DepartmentController::class, 'create'])->name('departments.create');
    Route::get('/departments/{department}', [DepartmentController::class, 'show'])->name('departments.show');
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
    Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');


    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar.index');
    Route::get('/calendar/events', [App\Http\Controllers\CalendarController::class, 'getTasks'])->name('calendar.events');



    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');


    Route::get('/profile/settings', [UserController::class, 'editSettings'])->name('profile.settings');
    Route::post('/profile/settings', [UserController::class, 'updateSettings'])->name('profile.settings.update');


    // *** Notifications mark all read AJAX route ***
    Route::post('/notifications/mark-all-read-ajax', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['status' => 'success']);
    })->name('notifications.markAllReadAjax');



    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('roles_permissions', [RolePermissionController::class, 'index'])->name('roles_permissions.index');
        Route::post('roles_permissions/createRole', [RolePermissionController::class, 'createRole'])->name('roles_permissions.createRole');
        Route::post('roles_permissions/createPermission', [RolePermissionController::class, 'createPermission'])->name('roles_permissions.createPermission');
        Route::post('roles_permissions/assignPermissions', [RolePermissionController::class, 'assignPermissionsToRole'])->name('roles_permissions.assignPermissionsToRole');
        Route::get('roles_permissions/editRole/{id}', [RolePermissionController::class, 'editRole'])->name('roles_permissions.editRole');
        Route::put('roles_permissions/updateRole/{id}', [RolePermissionController::class, 'updateRole'])->name('roles_permissions.updateRole');
        Route::delete('roles_permissions/deleteRole/{id}', [RolePermissionController::class, 'deleteRole'])->name('roles_permissions.deleteRole');
    });
    Route::get('/toggle_dark', function () {
        session()->put('dark_mode', !session('dark_mode', false));
        return back();
    })->name('toggle_dark');
});
