<?php

declare(strict_types = 1);

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)
    ->name('login')
    ->middleware('guest');

Route::get('/register', Register::class)
    ->name('register')
    ->middleware('guest');

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/', Welcome::class)->name('home');
});
