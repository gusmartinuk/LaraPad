<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TagController;

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/upload-image', [UploadController::class, 'uploadImage'])->middleware('auth');


Route::middleware('auth')->group(function () {
    Route::resource('notes', NoteController::class)->except(['create', 'edit']);
});



Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Tag search AJAX endpoint
Route::get('/tags/search', [TagController::class, 'search'])->name('tags.search');

Route::get('/notes/tag/{tag}', [NoteController::class, 'filterByTag'])->name('notes.tag');

// Tags management routes
Route::middleware('auth')->group(function () {
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');
});



require __DIR__.'/auth.php';
