<?php

use App\Http\Controllers\Admin\FossilController;
use App\Http\Controllers\Admin\RockClassController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\MineralController;
use App\Http\Controllers\Admin\RockTypeController;
use App\Http\Controllers\Admin\RockController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\PageController;
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

// SSO
Route::get('/login-tpu', [AuthController::class, 'loginTpu'])->name('login_tpu');
Route::get('/sso/auth', [AuthController::class, 'ssoAuth']);
Route::get('/sso/logout', [AuthController::class, 'ssoLogout']);

Route::get('/login', [AuthController::class, 'loginForm'])->name('login_form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
//Route::get('/', [RockController::class, 'home'])->name('home');
Route::get('/', [PageController::class, 'home'])->name('home');
//TODO: check auth: show public for authorizes
Route::match(['get','post'],'/rock-list', [RockController::class, 'list'])->name('rock_list');
Route::get('/rock-info/{id}', [RockController::class, 'info'])->name('rock_info');
Route::get('/mineral-info/{id}', [MineralController::class, 'info'])->name('mineral_info');
Route::get('/fossil-info/{id}', [FossilController::class, 'info'])->name('fossil_info');

// MICROSCOPE
Route::get('/microscope', [PageController::class, 'microscope'])->name('microscope');
Route::group(['prefix' => '/microscope-photos'], function () {
    Route::get('/rock/{id}', [RockController::class, 'getMicroPhotosJson'])->name('micro_rock');
    Route::get('/mineral/{id}', [MineralController::class, 'getMicroPhotosJson'])->name('micro_mineral');
    Route::get('/fossil/{id}', [FossilController::class, 'getMicroPhotosJson'])->name('micro_fossil');
});

//TODO: configure access by
//RockController::class)->only(['index']);
//RockController::class)->except(['destroy']);
Route::group(['prefix' => '/admin', 'middleware' => 'content_manager'], function () {
    Route::resource('/rocks', RockController::class)->except(['destroy']);
    Route::resource('/rock-types', RockTypeController::class)->except(['destroy']);
    Route::resource('/minerals', MineralController::class)->except(['destroy']);
    Route::resource('/fossils', FossilController::class)->except(['destroy']);
    Route::resource('/rock-classes', RockClassController::class)->except(['destroy']);
});

Route::group(['prefix' => '/admin', 'middleware' => 'admin'], function () {
    Route::resource('/rocks', RockController::class);
    Route::resource('/rock-types', RockTypeController::class);
    Route::resource('/minerals', MineralController::class);
    Route::resource('/fossils', FossilController::class);
    Route::resource('/rock-classes', RockClassController::class);
    Route::resource('/users', UserController::class);
    Route::get('/dictionary/all/{entity}', [DictionaryController::class, 'all'])->name('get_all_dicts');
    /** params example: /admin/dictionary/edit?entity=RockSquad&id=4 */
    Route::get('/dictionary/edit', [DictionaryController::class, 'edit'])
        ->name('dict_edit_view');
    Route::match(['post', 'put'], '/dictionary/update', [DictionaryController::class, 'update'])
        ->name('dict_update');
    Route::delete('/dictionary/destroy', [DictionaryController::class, 'destroy'])
        ->name('dict_destroy');
});


Route::view('testLte','admin.adminLte');

Route::any('{catchall}', [PageController::class, 'notfound'])->where('catchall', '.*');
