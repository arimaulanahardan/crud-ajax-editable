<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',  [ProductController::class, 'index'])->name('products.index');
Route::post('/', [ProductController::class, 'store'])->name('products.store');
Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
