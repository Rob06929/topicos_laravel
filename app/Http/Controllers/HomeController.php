<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function welcome() {
        return view('welcome',["login"=>true,"dashboard"=>false]);
    }

    function mapa() {
        $denuncias= new DenunciaController();
        $tipo=new DenunciaTipoController();
        $estado=new DenunciaEstadoController();
        return view('mapa',["login"=>true,"dashboard"=>true,"denuncias"=>$denuncias->index(),"tipos"=>$tipo->index(),"estados"=>$estado->index()]);
    }
}
