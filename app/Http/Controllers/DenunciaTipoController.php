<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Denuncia;
use App\Models\DenunciaTipo;
use App\Models\Funcionario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function index2()
    {
        $data = Auth::user();
        $persona = Persona::find($data->id_persona);
        $funcionario = Funcionario::where('id_persona', $persona->id)->first();
        $area = DenunciaTipo::find($funcionario->id_area);
        $areas = Area::all();
        $complaints_type = DenunciaTipo::all();

        return view('denuncia_types.type_complaints', ['usuario' => $data, 'persona' => $persona, 'area' => $area, 'complaints_type' => $complaints_type]);
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
        $typeComplaint = new DenunciaTipo();
        $typeComplaint->nombre = $request->nombre;
        $typeComplaint->descripcion = $request->descripcion;
        $typeComplaint->id_area = $request->id_area;
        $typeComplaint->save();
        return $typeComplaint;
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
        $data = Denuncia::find($id);
        return $data;
    }
    public function getTypesComplaints(Request $request)
    {
        $data = DenunciaTipo::select('denuncia_tipos.*', 'areas.nombre as area_name')
            ->join('areas', 'areas.id', 'denuncia_tipos.id_area')
            ->get();
        return $data;
    }
}
