<?php

namespace App\Http\Controllers;

use App\Models\FailsPassword;
use Carbon\Carbon;

use Illuminate\Http\Request;

class FailsPasswordController extends Controller
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
    public function store($id)
    {
        $data=FailsPassword::where("id_usuario",$id)->first();
            $data->intentos=$data->intentos+1;
            $data->fecha_ultimo_intento=Carbon::now(new \DateTimeZone('America/La_Paz'));
            if ($data->intentos>=3) {
                $data->fecha_bloqueo=Carbon::now(new \DateTimeZone('America/La_Paz'));    
                return "block";
            }
            $data->save();
        return "ready";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FailsPassword  $failsPassword
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=FailsPassword::where("id_usuario",$id)->first();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FailsPassword  $failsPassword
     * @return \Illuminate\Http\Response
     */
    public function edit(FailsPassword $failsPassword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FailsPassword  $failsPassword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FailsPassword $failsPassword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FailsPassword  $failsPassword
     * @return \Illuminate\Http\Response
     */
    public function destroy(FailsPassword $failsPassword)
    {
        //
    }
}
