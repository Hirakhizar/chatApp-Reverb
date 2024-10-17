<?php

use App\Http\Controllers\Chatting;
use App\Http\Controllers\ChattingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/chat/room', [ChattingController::class,'index'])->name('chatroom');
Route::post('/chat/fireMessage', [ChattingController::class,'fireMessage'])->name('sendMessage');
