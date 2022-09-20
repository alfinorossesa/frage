<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DataAdminController;
use App\Http\Controllers\Admin\DataAnswerController;
use App\Http\Controllers\Admin\DataAnswerReportController;
use App\Http\Controllers\Admin\DataQuestionController;
use App\Http\Controllers\Admin\DataQuestionReportController;
use App\Http\Controllers\Admin\DataTagsController;
use App\Http\Controllers\Admin\DataUserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'middleware' => ['auth:web','IsAdmin']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    Route::get('/data-admin', [DataAdminController::class, 'index'])->name('dataAdmin.index');
    Route::get('/data-admin/addAdmin', [DataAdminController::class, 'addAdmin'])->name('dataAdmin.addAdmin');
    Route::put('/data-admin/addAdmin', [DataAdminController::class, 'addAdminUpdate'])->name('dataAdmin.addAdminUpdate');
    Route::put('/data-admin/{user}/disAdmin', [DataAdminController::class, 'disAdmin'])->name('dataAdmin.disAdmin');

    Route::get('/data-user', [DataUserController::class, 'index'])->name('dataUser.index');
    Route::get('/data-user/{user}/detail', [DataUserController::class, 'show'])->name('dataUser.show');
    Route::delete('/data-user/{user}/delete', [DataUserController::class, 'destroy'])->name('dataUser.destroy');

    Route::get('/data-question', [DataQuestionController::class, 'index'])->name('dataQuestion.index'); 
    Route::get('/data-question/{question}/detail', [DataQuestionController::class, 'show'])->name('dataQuestion.show');
    Route::delete('/data-question/{question}/delete', [DataQuestionController::class, 'destroy'])->name('dataQuestion.destroy');

    Route::get('/data-answer', [DataAnswerController::class, 'index'])->name('dataAnswer.index');
    Route::get('/data-answer/{answer}/detail', [DataAnswerController::class, 'show'])->name('dataAnswer.show');
    Route::delete('/data-answer/{answer}/delete', [DataAnswerController::class, 'destroy'])->name('dataAnswer.destroy');

    Route::get('/data-tags', [DataTagsController::class, 'index'])->name('dataTags.index');
    Route::get('/data-tags/{tag}/detail', [DataTagsController::class, 'show'])->name('dataTags.show');
    Route::delete('/data-tags/{tag}/delete', [DataTagsController::class, 'destroy'])->name('dataTags.destroy');

    Route::get('/question-report', [DataQuestionReportController::class, 'index'])->name('dataQuestionReport.index');
    Route::get('/question-report/{report}/detail', [DataQuestionReportController::class, 'show'])->name('dataQuestionReport.show');
    Route::delete('/question-report/{report}/delete', [DataQuestionReportController::class, 'destroy'])->name('dataQuestionReport.destroy');
    Route::delete('/question-report/{question}/question-delete', [DataQuestionReportController::class, 'questionDelete'])->name('dataQuestionReport.questionDelete');

    Route::get('/answer-report', [DataAnswerReportController::class, 'index'])->name('dataAnswerReport.index');
    Route::get('/answer-report/{report}/detail', [DataAnswerReportController::class, 'show'])->name('dataAnswerReport.show');
    Route::delete('/answer-report/{report}/delete', [DataAnswerReportController::class, 'destroy'])->name('dataAnswerReport.destroy');
    Route::delete('/answer-report/{answer}/answer-delete', [DataAnswerReportController::class, 'answerDelete'])->name('dataAnswerReport.answerDelete');
});