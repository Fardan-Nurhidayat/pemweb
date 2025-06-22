<?php

use App\Livewire\DetailKursus;
use App\Livewire\User;
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

    Route::get('/materi' , Materi::class)->name('materi.index');
    Route::get('/kursus' , Kursus::class)->name('kursus.index');
    Route::get('/kursus/{id}' , DetailKursus::class)->name('kursus.detail');
    Route::get('/users', User::class)->name('users.index');
});
