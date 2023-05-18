<?php

namespace App\Http\Controllers;

use App\Models\UpdatePassword;
use Illuminate\Http\Request;
use App\Models\User;

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
    public function update($id,Request $request)
    {
            $data=User::find($id);
            $contrasenaAnterior = $data->password;
            $fechaActual = date("Y-m-d H:i:s");
            $updatePassword=UpdatePassword::where("id_usuario",$data->id)->first();
            $updatePassword->fecha = $fechaActual;
            $updatePassword->password = $contrasenaAnterior;
            // return $date=[
            //     'fecha'=> $fechaActual,
            //     'user'=> $data,
            //     'updatePassword'=> $updatePassword,
            // ];
            // $updatePassword->save(); // por alguna razon me da error aca, no deja guardar
            // return 'todo bien';

            $data->password=$request->password;
            $data->save();
    
            return json_encode("exito");
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
