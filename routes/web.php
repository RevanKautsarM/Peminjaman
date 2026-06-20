<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;

// Halaman utama otomatis redirect ke daftar barang
Route::get('/', function () {
    return redirect()->route('items.index');
});

// Route CRUD Barang
Route::resource('items', ItemController::class);

// Route Transaksi Peminjaman
Route::get('loans', [LoanController::class, 'index'])->name('loans.index');
Route::get('loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('loans', [LoanController::class, 'store'])->name('loans.store');
Route::put('loans/{id}/return', [LoanController::class, 'returnItem'])->name('loans.return');