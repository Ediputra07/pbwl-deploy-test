<?php

use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

// Klien API Modul 4 (login memakai token Sanctum sendiri)
Route::view('/klien', 'klien.mata-kuliah')->name('klien.mata-kuliah');

// Rute umum yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD Mata Kuliah (Modul 3) kini berada di balik login
    Route::resource('mata-kuliah', MataKuliahController::class);
});

// 1. Khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// 2. Khusus Dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen/dashboard', function () {
        return view('dosen.dashboard');
    })->name('dosen.dashboard');
});

// 3. Khusus Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', function () {
        return view('mahasiswa.dashboard');
    })->name('mahasiswa.dashboard');
});

// 4. Contoh Multiple Role (Admin ATAU Dosen bisa akses)
Route::middleware(['auth', 'role:admin|dosen'])->group(function () {
    Route::get('/laporan-progres', function () {
        return "Halaman Laporan Progres (Dapat diakses Admin dan Dosen)";
    })->name('laporan.progres');
});

require __DIR__.'/auth.php';
