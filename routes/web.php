<?php

use App\Http\Controllers\MataKuliahController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('mata-kuliah.index'));
Route::resource('mata-kuliah', MataKuliahController::class);

Route::view('/klien', 'klien.mata-kuliah')->name('klien.mata-kuliah');
