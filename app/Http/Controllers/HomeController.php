<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function welcome() {
        return view('welcome',["login"=>true,"dashboard"=>false]);
    }

    function mapa() {
        return view('mapa',["login"=>true,"dashboard"=>true]);
    }
}
