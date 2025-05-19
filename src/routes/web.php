<?php

use App\Http\Controllers\Samura;
use Illuminate\Support\Facades\Route;

Route::get('/',[ Samura::class,'index'])->name('index');
Route::get('/table',[ Samura::class,'table'])->name('table');
Route::get('/show/{id}',[ Samura::class,'show'])->name('show');
