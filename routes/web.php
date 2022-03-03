<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculateBillController;
use App\Http\Controllers\VideoSearchController;
use App\Http\Controllers\WordCountController;

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

 // Calculate bill
Route::get('billCalculator/calculate-bill', [CalculateBillController::class,'index']);
Route::post('billCalculator/calculate-bill', [CalculateBillController::class,'load']);

 // Search Video
 Route::get('videoSearch/video-search', [VideoSearchController::class,'index']);
 Route::post('videoSearch/video-search', [VideoSearchController::class,'load']);

  // Word Counter
  Route::get('wordCounter/word-count', [WordCountController::class,'index']);
  Route::post('wordCounter/word-count', [WordCountController::class,'load']);

