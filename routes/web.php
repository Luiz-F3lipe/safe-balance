<?php

declare(strict_types = 1);

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Category\Index as CategoryIndex;
use App\Livewire\Contact\Index as ContactIndex;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Transaction\Create as TransactionCreate;
use App\Livewire\Transaction\Edit as TransactionEdit;
use App\Livewire\Transaction\Index as TransactionIndex;
use App\Livewire\User\Index as UserIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)
    ->name('login')
    ->middleware('guest');

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::get('/register', Register::class)
    ->name('register')
    ->middleware('guest');

Route::group(['middleware' => 'auth'], function (): void {
    Route::get('/', DashboardIndex::class)->name('home');

    Route::get('/users', UserIndex::class)->name('users.index');
    Route::get('/categories', CategoryIndex::class)->name('categories.index');
    Route::get('/contacts', ContactIndex::class)->name('contacts.index');
    Route::get('/transactions', TransactionIndex::class)->name('transactions.index');
    Route::get('/transactions/create', TransactionCreate::class)->name('transactions.create');
    Route::get('/transactions/{id}/edit', TransactionEdit::class)->name('transactions.edit');
});
