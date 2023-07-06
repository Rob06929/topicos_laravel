<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DenunciaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AreaController;



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

//Route::get('/', function () {
//    return view('update_periodos');
//})->name('form');

Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
Route::get('/mapa', [HomeController::class, 'mapa'])->name('mapa');

Route::get('/login', [HomeController::class, 'login'])->name('login');

Route::get('/register', [HomeController::class, 'register'])->name('register');

Route::post('/login_user', [UsuarioController::class, 'login'])->name('login_user');
Route::get('/logout', [UsuarioController::class, 'logout'])->name('logout');
Route::get('/inicio', [UsuarioController::class, 'inicio'])->name('inicio');

Route::get('/lista_denuncias', [UsuarioController::class,'lista_denuncias'])->name('lista_denuncias');
Route::get('/info_denuncia/{id}', [UsuarioController::class,'info_denuncia'])->name('info_denuncia');


Route::get('/lista_areas', [UsuarioController::class,'lista_areas'])->name('lista_areas');

Route::post('/registro_area', [AreaController::class,'store'])->name('registro_area');



Route::get('verification', 'UserController@info_verification')->name('verification');

