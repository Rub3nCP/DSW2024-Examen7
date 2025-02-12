<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación.
| Estas rutas se cargan por el RouteServiceProvider y se asignan al
| grupo de middleware "web". ¡Haz algo increíble!
|
*/

Route::get('/', [PostController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('posts', PostController::class)->except(['destroy']);
    Route::get('/posts/{id}/read', [PostController::class, 'read'])->name('posts.read');
    Route::post('/posts/{post}/vote', [PostController::class, 'vote'])->name('posts.vote');
    Route::get('/topics/{id}/posts', [TopicController::class, 'posts'])->name('topics.posts');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
});

require __DIR__.'/auth.php';
