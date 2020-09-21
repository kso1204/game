<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AttackController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/stage',[HomeController::class, 'stage'])->name('stage'); 
Route::get('/setting',[HomeController::class, 'setting'])->name('setting');

Route::post('app/attack',[AttackController::class, 'attack'])->name('attack');

Route::get('app/get_user/{id}',[UserController::class, 'getUser']);
