<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MineralController;
use App\Http\Controllers\Admin\RockTypeController;
use App\Http\Controllers\Admin\RockController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/', [RockController::class, 'index'])->name('home');
Route::get('/info/{id}', [RockController::class, 'info'])->name('info');

Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    Route::resource('/rocks', RockController::class);
    Route::resource('/rock-types', RockTypeController::class);
    Route::resource('/minerals', MineralController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/users', UserController::class);
});
