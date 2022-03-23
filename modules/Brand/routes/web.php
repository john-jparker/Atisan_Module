<?php

use Illuminate\Foundation\Application;
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


Route::middleware(['auth:sanctum', 'verified'])->get('/brand', function () {
    return Inertia::render('Brand::Brand');
})->name('brand.create');

//Route::middleware(['auth:sanctum', 'verified'])->post('/brand', function (\Illuminate\Http\Request $request) {
//    dd($request->all());
//})->name('brand.store');

Route::post('brand', function (\Illuminate\Http\Request $request){
    dd($request->all());
});
