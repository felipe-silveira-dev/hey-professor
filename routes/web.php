<?php

use App\Http\Controllers\Question\{LikeController, UnlikeController};
use App\Http\Controllers\{DashboardController, ProfileController, QuestionController};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (app()->isLocal()) {
        auth()->loginUsingId(1);

        return to_route('dashboard');
    }

    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::post('question/store', [QuestionController::class, 'store'])->name('question.store');
Route::post('question/like/{question}', LikeController::class)->name('question.like');
Route::post('question/unlike/{question}', UnlikeController::class)->name('question.unlike');

require __DIR__ . '/auth.php';
