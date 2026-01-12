<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TalkController;
use App\Http\Controllers\UserController;

Route::get('/', [TalkController::class, 'index'])->name('home');
Route::post('/talks', [TalkController::class, 'store'])->name('talks.store')->middleware('auth');
Route::put('/talks/{talk}', [TalkController::class, 'update'])->name('talks.update')->middleware('auth');
Route::delete('/talks/{talk}', [TalkController::class, 'destroy'])->name('talks.destroy')->middleware('auth');
Route::put('/user/update', [UserController::class, 'update'])->name('user.update')->middleware('auth');
Route::put('/user/change-password', [UserController::class, 'changePassword'])->name('user.changePassword')->middleware('auth');
Route::delete('/user/delete', [UserController::class, 'deleteAccount'])->name('user.delete')->middleware('auth');

require __DIR__.'/auth.php';
