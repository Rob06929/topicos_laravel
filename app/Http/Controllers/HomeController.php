<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    function welcome() {
        return view('welcome',["login"=>true,"dashboard"=>false,"register"=>false]);
    }

    function login() {
        return view('login',["login"=>false,"dashboard"=>true,"register"=>false]);
    }

    function register() {
        return view('register',["login"=>true,"dashboard"=>true,"register"=>false]);
    }

    function mapa() {
        $denuncias= new DenunciaController();
        $tipo=new DenunciaTipoController();
        $estado=new DenunciaEstadoController();
        return view('mapa',["login"=>true,"dashboard"=>true,"denuncias"=>$denuncias->index(),"tipos"=>$tipo->index(),"estados"=>$estado->index()]);
    }
}
