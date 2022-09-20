<?php

use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GithubAuthController;
use App\Http\Controllers\auth\NewPasswordController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function(){
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.auth');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

    Route::get('auth/github', [GithubAuthController::class, 'redirectToGithub'])->name('github.auth');
    Route::get('auth/github/callback', [GithubAuthController::class, 'handleGithubCallback']);

    Route::get('auth/facebook', [FacebookAuthController::class, 'redirectToFacebook'])->name('facebook.auth');
    Route::get('auth/facebook/callback', [FacebookAuthController::class, 'handleFacebookCallback']);

    Route::get('/signup', [SignupController::class, 'index'])->name('signup');
    Route::post('/signup', [SignupController::class, 'store'])->name('signup.store');

    Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('forgotPassword');
    Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('forgotPassword.store');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function(){
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed'])->name('verification.verify');
});