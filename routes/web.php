<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {
    Route::get('tasks/trashed', [TaskController::class, 'trashed'])->name('tasks.trashed');
    Route::patch('tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');
    Route::delete('tasks/{task}/force-delete', [TaskController::class, 'forceDelete'])->name('tasks.forceDelete');
    Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::resource('tasks', TaskController::class);  
});