<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/posts', [PostController::class, 'index'])->name('posts');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('show-post');
Route::post('/create-post', [PostController::class, 'create'])->name('create');

Route::put('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class, 'destroy']);

// Comments

Route::post('/posts/{post}/comments', [CommentController::class, 'storeComment'])->name('create-comment');



