<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PostController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('posts', PostController::class)->middleware('auth');  
    Route::get('/posts/{id}/read', [PostController::class, 'read'])->name('posts.read');
    Route::post('/posts/{post}/vote', [PostController::class, 'vote'])->name('posts.vote')->middleware('auth');
    Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class);});
    Route::get('/change-theme', 'PostController@changeTheme')->name('changeTheme');
    Route::get('/change-theme', [PostController::class, 'changeTheme'])->name('changeTheme');
});



require __DIR__.'/auth.php';
