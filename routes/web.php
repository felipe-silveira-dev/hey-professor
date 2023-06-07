<?php

use App\Http\Controllers\Question\{LikeController, PublishController, UnlikeController};
use App\Http\Controllers\{DashboardController, ProfileController, QuestionController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->isLocal()) {
        auth()->loginUsingId(1);

        return to_route('dashboard');
    }

    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Questions routes
    Route::prefix('question/')->name('question.')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('index');
        Route::post('store', [QuestionController::class, 'store'])->name('store');
        Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('edit');
        Route::post('like/{question}', LikeController::class)->name('like');
        Route::post('unlike/{question}', UnlikeController::class)->name('unlike');
        Route::put('publish/{question}', PublishController::class)->name('publish');
        Route::delete('destroy/{question}', [QuestionController::class, 'destroy'])->name('destroy');

    });
    // End Questions routesag

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // End Profile routes
});

require __DIR__ . '/auth.php';
