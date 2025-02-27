<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('administration/users/data-table', [App\Http\Controllers\Administration\UsersController::class, 'dataTable'])->name('administration.users.data-table');
    Route::resource('administration/users', App\Http\Controllers\Administration\UsersController::class, ['as' => 'administration']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
