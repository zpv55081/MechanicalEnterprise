<?php

use App\Http\Controllers\UIController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('priv', function () {
    return view('privet', ['name' => 'Samantha']);
});

Route::match(['get', 'post'], 'generateco', [UIController::class, 'generateCommercialOffer']);
