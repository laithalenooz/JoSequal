<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::middleware('auth')->group(function (){
    Route::get('listpage', [App\Http\Controllers\UserController::class, 'ViewTable'])->name('user.listpage');
    Route::get('profile', [App\Http\Controllers\UserController::class, 'index'])->name('user.profile');
    Route::post('profile', [App\Http\Controllers\UserController::class, 'update'])->name('user.profile.update');
    Route::get('delete/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy')->middleware('password.confirm');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::view('/posts', 'user_posts')->name('user.posts');
    Route::get('/post/edit/{id}', [App\Http\Controllers\UserController::class, 'showPost'])->name('update.post');
    Route::post('/post/edit/{id}', [App\Http\Controllers\UserController::class, 'updatePost'])->name('update.post.submit');
    Route::get('/post/destroy/{id}', [App\Http\Controllers\UserController::class, 'destroyPost'])->name('delete.post');
    Route::post('/post', [App\Http\Controllers\HomeController::class, 'store'])->name('post.create');
    Route::get('/post/{id}', [App\Http\Controllers\HomeController::class, 'showSinglePost'])->name('view.post');
    Route::get('reset/server', function () {
        Artisan::call('migrate:fresh');
        Artisan::call('optimize');
        return redirect('/');

    });
});
