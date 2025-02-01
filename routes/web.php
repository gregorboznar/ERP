<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MachineController;


Route::get('/', function () {
    return view('welcome');
});
Route::resource('machines', MachineController::class);

Route::get('/terms', function () {
    return view('terms');
});
