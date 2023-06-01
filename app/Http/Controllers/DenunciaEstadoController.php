<?php

namespace App\Http\Controllers;

use App\Models\DenunciaEstado;
use Illuminate\Http\Request;

class DenunciaEstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DenunciaEstado::all();
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DenunciaEstado  $denunciaEstado
     * @return \Illuminate\Http\Response
     */
    public function show(DenunciaEstado $denunciaEstado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DenunciaEstado  $denunciaEstado
     * @return \Illuminate\Http\Response
     */
    public function edit(DenunciaEstado $denunciaEstado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DenunciaEstado  $denunciaEstado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DenunciaEstado $denunciaEstado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DenunciaEstado  $denunciaEstado
     * @return \Illuminate\Http\Response
     */
    public function destroy(DenunciaEstado $denunciaEstado)
    {
        //
    }

    public function getEstado($id)
    {
        $data=DenunciaEstado::find($id);
        return $data;
    }
}
