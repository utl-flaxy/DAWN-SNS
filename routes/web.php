<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowController;

Route::middleware('web')->group(function () {

    require __DIR__ . '/auth.php';

    Route::get('/', function () {
        return redirect()->route('posts.index');
    })->name('home');

    Route::middleware('auth')->group(function () {

        // 投稿
        Route::resource('posts', PostController::class);

        // 仕様寄せ（任意）
        Route::get('/top', [PostController::class, 'index'])->name('top');

        // ユーザー検索（※ users/{id} より先！）
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

        // プロフィール（自分）
        Route::get('/profile/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/profile/update', [UserController::class, 'update'])->name('users.update');

        // プロフィール（他ユーザー）
        Route::get('/users/{id}', [UserController::class, 'show'])
            ->whereNumber('id')
            ->name('users.show');

        // フォロー
        Route::get('/follow/following', [FollowController::class, 'following'])->name('follow.following');
        Route::get('/follow/followers', [FollowController::class, 'followers'])->name('follow.followers');
        Route::post('/follow/{user_id}', [FollowController::class, 'store'])->name('follow.store');
        Route::delete('/follow/{user_id}', [FollowController::class, 'destroy'])->name('follow.destroy');
    });
});
