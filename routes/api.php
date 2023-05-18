<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\EmailConfirmationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //return $request->user();
//});

Route::get('send_correo',function(){
    //Mail::to('carlosmercado06929@gmail.com')->send(new SendMail() );
    $data = array('name'=>"Virat Gandhi");

    Mail::send('mail.confirmacion', $data, function($message) {
        $message->to('carlosmercado06929@gmail.com', 'Carlos Mercado')->subject
           ('ALCALDIA - Confirmación de correo');
           $message->from('robfernandez06929@gmail.com','Alcaldia');
     });
    return "correo enviado";
})->name("send_correo");

Route::get('/actions/get-user/{name}', [UsuarioController::class, 'get_data']);
Route::get('/actions/get-user-id/{id}', [UsuarioController::class, 'get_data_id']);

Route::post('/actions/passwordUpdate', [UpdatePasswordController::class, 'index']);
Route::post('/actions/passwordChange/{id}', [UpdatePasswordController::class, 'update']);


Route::post('/actions/saveUser', [UsuarioController::class, 'apiSave']);
Route::post('/actions/loginUser', [UsuarioController::class, 'apiLogin']);
Route::post('/actions/get_auth_email', [UsuarioController::class, 'get_auth_email']);

Route::get('/actions/confirmation_email/{uid}/{id}', [EmailConfirmationController::class, 'confirmationEmail']);
Route::get('/actions/confirmation_register/{uid}/{id}', [EmailConfirmationController::class, 'confirmationregister']);


