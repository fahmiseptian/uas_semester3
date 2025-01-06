<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');

    Route::get('/order', [OrdersController::class, 'index'])->name('orders');
    Route::get('/order/{id}', [OrdersController::class, 'order']);
    Route::post('/order/add', [OrdersController::class, 'store']);
    Route::post('/order/update', [OrdersController::class, 'update']);
    Route::Delete('/order/delete/{id}', [OrdersController::class, 'delete']);
    Route::get('/export-pdf', [OrdersController::class, 'exportPdf']);


    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::post('/pengguna/add', [PenggunaController::class, 'store']);
});
