<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::post('/brand', [\Rsruman\Brand\Controllers\BrandController::class, 'store'])->name('brand.store');
    Route::get('/brand', [\Rsruman\Brand\Controllers\BrandController::class, 'create'])->name('brand.create');
});
