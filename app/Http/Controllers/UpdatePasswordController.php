<?php

namespace App\Http\Controllers;

use App\Models\UpdatePassword;
use App\Models\Variable;

use Illuminate\Http\Request;
use App\Models\User;
use Config;

use Carbon\Carbon;
class UpdatePasswordController extends Controller
{

    public static function getPeriodoUpdate()
    {
        $data=Variable::find(1);
        return $data->periodo_password;
    }   

    public static function setPeriodoUpdate( Request $request)
    {
        $data=Variable::find(1);
        $data->periodo_password=$request->valor;
        $data->save();
        return redirect()->route('form');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data1=Variable::find(1);
        
        $data=UpdatePassword::where("id_usuario",$request->id_usuario)->first();
        
        
        $fechaReciente = Carbon::parse($request->fecha);

        if ($data) {
            $fechaAntigua  = Carbon::parse($data->fecha);
            $cantidadDias = $fechaAntigua->diffInDays($fechaReciente);
            // echo $cantidadDias;
            if ($data1->periodo_password<=$cantidadDias) {
                return json_encode(["excedeDias"=>"true"]);
            }else{
                return json_encode(["excedeDias"=>"false"]);
            }    
        }else{
            $data=User::find($request->id_usuario);

            $fechaAntigua  = Carbon::parse($data->create_at);
            $cantidadDias = $fechaAntigua->diffInDays($fechaReciente);

            if ($data1->periodo_password<=$cantidadDias) {
                return json_encode(["excedeDias"=>"true"]);
            }else{
                return json_encode(["excedeDias"=>"false"]);
            }    

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
        return $periodo_update;
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
            $fechaActual = Carbon::now(new \DateTimeZone('America/La_Paz'));
            $updatePassword=new UpdatePassword();
            
            //UpdatePassword::where("id_usuario",$data->id)->first();
            // echo $updatePassword;

            $updatePassword->fecha = $fechaActual;
            $updatePassword->password = $contrasenaAnterior;
            $updatePassword->id_usuario=$id;
            $updatePassword->periodoUpdate=30;
            $updatePassword->save();
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
