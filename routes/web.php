<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

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

Route::get('/', function () {
    return redirect()->route('cars.index');
});

// Dashboard
Route::get('/dashboard', [CarController::class, 'index'])->name('dashboard');

// Cars CRUD
Route::resource('cars', CarController::class);
