<?php

use App\Http\Controllers\AddressCategorieController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BodyTypeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskPointController;
use App\Http\Controllers\VehicleCetegorieController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
    
    Route::resource('address', AddressController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('employees', EmployeeController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('vehicles', VehicleController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('tasks', TaskController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::prefix('tasks/{task}')->group(function () {
        Route::resource('task-points', TaskPointController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    });

    Route::get('/vehicle-statuses', [VehicleStatusController::class, 'index']);
    Route::get('/vehicle-categories', [VehicleCetegorieController::class, 'index']);
    Route::get('/body-types', [BodyTypeController::class, 'index']);
    
    Route::get('/address-categories', [AddressCategorieController::class, 'index']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});