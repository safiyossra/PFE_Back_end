<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassagerController;

Route::resource('passagers',PassagerController::class);
Route::get('/gestionpassager', [PassagerController::class, 'loadPassager']);
Route::get('/createPassager', [PassagerController::class, 'createPassager']);
Route::get('/editPassager', [PassagerController::class, 'editPassager']);
Route::get('/deletepassager', [PassagerController::class, 'deletepassager']);
