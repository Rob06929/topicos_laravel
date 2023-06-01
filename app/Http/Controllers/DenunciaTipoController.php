<?php

namespace App\Http\Controllers;

use App\Models\DenunciaTipo;
use Illuminate\Http\Request;

class DenunciaTipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DenunciaTipo::all();
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
     * @param  \App\Models\DenunciaTipo  $denunciaTipo
     * @return \Illuminate\Http\Response
     */
    public function show(DenunciaTipo $denunciaTipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DenunciaTipo  $denunciaTipo
     * @return \Illuminate\Http\Response
     */
    public function edit(DenunciaTipo $denunciaTipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DenunciaTipo  $denunciaTipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DenunciaTipo $denunciaTipo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DenunciaTipo  $denunciaTipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(DenunciaTipo $denunciaTipo)
    {
        //
    }

    public function getTipo($id)
    {
        $data=Denuncia::find($id);
        return $data;
    }
}
