<?php

use App\Http\Controllers\AnswerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;


require __DIR__.'/adminDashboard.php';
require __DIR__.'/auth.php';

Route::get('/', HomeController::class);

Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
    Route::get('/{user}/{username}/profile', [ProfileController::class, 'index'])->name('index');
    Route::middleware('auth')->group(function() {
        Route::get('/{user}/{username}/profile/update-profile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
        Route::put('/{user}/{username}/profile/update-profile', [ProfileController::class, 'updateProfileStore'])->name('updateProfileStore');
        Route::get('/{user}/{username}/profile/change-password', [ProfileController::class, 'changePassword'])->name('changePassword');
        Route::put('/{user}/{username}/profile/change-password', [ProfileController::class, 'changePasswordStore'])->name('changePasswordStore');
    });
    Route::get('/{user}/{username}/activity/summary', [ProfileController::class, 'activity'])->name('activity');
    Route::get('/{user}/{username}/activity/question', [ProfileController::class, 'question'])->name('question');
    Route::get('/{user}/{username}/activity/answer', [ProfileController::class, 'answer'])->name('answer');
    Route::get('/{user}/{username}/activity/votes', [ProfileController::class, 'votes'])->name('votes');
    Route::get('/{user}/{username}/activity/comment', [ProfileController::class, 'comment'])->name('comment');
    Route::get('/{user}/{username}/activity/likes-question', [ProfileController::class, 'likesQuestion'])->name('likesQuestion');
    Route::get('/{user}/{username}/activity/likes-answer', [ProfileController::class, 'likesAnswer'])->name('likesAnswer');
});

Route::group(['prefix' => 'question', 'as' => 'question.'], function(){
    Route::get('/', [QuestionController::class, 'index'])->name('index');
    Route::get('/{question}/{slug}', [QuestionController::class, 'show'])->name('show');
    Route::get('/search', [QuestionController::class, 'search'])->name('search');
    Route::middleware('auth')->group(function() {
        Route::get('/ask-question', [QuestionController::class, 'askQuestion'])->name('askQuestion');
        Route::post('/ask-question', [QuestionController::class, 'askQuestionStore'])->name('askQuestionStore');
        Route::get('/{question}/{slug}/edit', [QuestionController::class, 'edit'])->name('edit');
        Route::put('/{question}/{slug}/update', [QuestionController::class, 'update'])->name('update');
        Route::put('/{question}/question-votes-count', [QuestionController::class, 'votesCount'])->name('votesCount');
        Route::put('/{question}/question-like', [QuestionController::class, 'like'])->name('like');
        Route::delete('/{question}/{slug}/delete', [QuestionController::class, 'destroy'])->name('destroy');
        Route::get('/{question}/{slug}/report', [QuestionController::class, 'report'])->name('report');
        Route::post('/{question}/{slug}/report', [QuestionController::class, 'reportStore'])->name('reportStore');
        Route::get('/{question}/{slug}/report/{report}/thank-you', [QuestionController::class, 'reportCallback'])->name('reportCallback');
    });
});

Route::group(['as' => 'answer.'], function(){
    Route::post('/answer/{question}/store', [AnswerController::class, 'store'])->name('store');
    Route::middleware('auth')->group(function() {
        Route::post('/answer/{answer}/comment', [AnswerController::class, 'commentStore'])->name('comment');
        Route::get('/question/{question}/{slug}/answer/{answer}/edit', [AnswerController::class, 'edit'])->name('edit');
        Route::put('/question/{question}/{slug}/answer/{answer}/update', [AnswerController::class, 'update'])->name('update');
        Route::put('/answer/{answer}/answer-votes-count', [AnswerController::class, 'votesCount'])->name('votesCount');
        Route::put('/answer/{answer}/answer-like', [AnswerController::class, 'like'])->name('like');
        Route::put('/answer/{answer}/best-answer', [AnswerController::class, 'bestAnswer'])->name('bestAnswer');
        Route::delete('/answer/{answer}/answer/delete', [AnswerController::class, 'destroy'])->name('destroy');
        Route::get('/answer/{answer}/report', [AnswerController::class, 'report'])->name('report');
        Route::post('/answer/{answer}/report', [AnswerController::class, 'reportStore'])->name('reportStore');
        Route::get('/answer/{answer}/report/{report}/thank-you', [AnswerController::class, 'reportCallback'])->name('reportCallback');
    });
    Route::get('/question/{question}/{slug}/answer/{answer}/comment', [AnswerController::class, 'answerComment'])->name('allComment');
});

Route::group(['prefix' => 'tag', 'as' => 'tag.'], function(){
    Route::get('/', [TagController::class, 'index'])->name('index');
    Route::get('/{tag}/questions', [TagController::class, 'questionByTag'])->name('questionByTag');
    Route::put('/{tag}/update', [TagController::class, 'update'])->name('update');
    Route::delete('/{tag}/delete', [TagController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'leaderboard', 'as' => 'leaderboard.'], function(){
    Route::get('/', [LeaderboardController::class, 'index'])->name('index');
});
