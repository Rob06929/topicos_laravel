<?php

namespace App\Http\Controllers;

use App\Models\DenunciaFoto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DenunciaFotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($url,$id_denuncia)
    {
        $data=new DenunciaFoto;
        $data->url=$url;
        $data->id_denuncia=$id_denuncia;
        $data->save();
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DenunciaFoto  $denunciaFoto
     * @return \Illuminate\Http\Response
     */
    public function show(DenunciaFoto $denunciaFoto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DenunciaFoto  $denunciaFoto
     * @return \Illuminate\Http\Response
     */
    public function edit(DenunciaFoto $denunciaFoto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DenunciaFoto  $denunciaFoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DenunciaFoto $denunciaFoto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DenunciaFoto  $denunciaFoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(DenunciaFoto $denunciaFoto)
    {
        
    }

    public static function getFoto($id)
    {
        return DenunciaFoto::where("id_denuncia",$id)->first();
    }
    public function storeFoto($base64)
    {
        
    }
}
