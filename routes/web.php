<?php

use App\Livewire\Kursus;
use App\Livewire\Materi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/materi' , Materi::class)->name('get-materi');
    Route::get('/kursus' , Kursus::class)->name('get-kursus');
});
