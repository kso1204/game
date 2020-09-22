<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttackController;
use App\Http\Controllers\RecordController;

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
    //dd(url('/')); ?? 이거 하니까 갑자기 됨?
    return view('welcome');
});

Auth::routes();

Route::get('/rule', [HomeController::class, 'rule'])->name('rule');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/stage',[HomeController::class, 'stage'])->name('stage'); 
Route::get('/setting',[HomeController::class, 'setting'])->name('setting');

Route::post('app/attack',[AttackController::class, 'attack'])->name('attack');
Route::post('app/skillOne',[AttackController::class, 'skillOne'])->name('skillOne');
Route::post('app/skillTwo',[AttackController::class, 'skillTwo'])->name('skillTwo');
Route::post('app/skillThree',[AttackController::class, 'skillThree'])->name('skillThree');
Route::post('app/skillFour',[AttackController::class, 'skillFour'])->name('skillFour');
Route::post('app/heal',[AttackController::class, 'heal'])->name('heal');
Route::post('app/reset',[AttackController::class, 'reset'])->name('reset');

Route::get('app/get_user',[UserController::class, 'getUser']);


Route::get('app/get_record',[RecordController::class, 'getRecord']);
