<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileLoadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 // File Load
Route::get('/file-load', [FileLoadController::class,'index']);
Route::post('/file-load', [FileLoadController::class,'load']);

