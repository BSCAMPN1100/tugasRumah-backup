<?php

use App\Http\Controllers\MasterController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/master', [MasterController::class, 'index']);
