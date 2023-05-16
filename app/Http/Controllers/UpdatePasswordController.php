<?php

namespace App\Http\Controllers;

use App\Models\UpdatePassword;
use Illuminate\Http\Request;
use Carbon\Carbon;
class UpdatePasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data=UpdatePassword::where("id_usuario",$request->id_usuario)->first();
        
        $fechaAntigua  = Carbon::parse($data->fecha);
        $fechaReciente = Carbon::parse($request->fecha);

        $cantidadDias = $fechaAntigua->diffInDays($fechaReciente);
        if ($data->periodoUpdate<=$cantidadDias) {
            return json_encode(["excedeDias"=>"true"]);
        }else{
            return json_encode(["excedeDias"=>"false"]);
        }
        
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
     * @param  \App\Models\UpdatePassword  $updatePassword
     * @return \Illuminate\Http\Response
     */
    public function show(UpdatePassword $updatePassword)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UpdatePassword  $updatePassword
     * @return \Illuminate\Http\Response
     */
    public function edit(UpdatePassword $updatePassword)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UpdatePassword  $updatePassword
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UpdatePassword $updatePassword)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UpdatePassword  $updatePassword
     * @return \Illuminate\Http\Response
     */
    public function destroy(UpdatePassword $updatePassword)
    {
        //
    }
}
