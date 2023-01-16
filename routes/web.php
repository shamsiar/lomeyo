<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'activeCountry']);

Route::prefix('{country}')->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    // Route::get('/page1', [HomeController::class, 'page1'])->name('page1');
    // Route::get('/page2', [HomeController::class, 'page2'])->name('page2');
});

// Route::get('/', [HomeController::class, 'index']);
Route::post('/', [HomeController::class, 'uploadImage'])->name('home.uploadImage');
// Route::post('/', [HomeController::class, 'changeCountryStatus'])->name('changeCountryStatus');
