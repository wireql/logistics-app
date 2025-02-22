<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register'])->name('user.register');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');
    
    Route::resource('address', AddressController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('employees', EmployeeController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});