<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;

use App\Models\EmailConfirmation;
use Illuminate\Http\Request;

class EmailConfirmationController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmailConfirmation  $emailConfirmation
     * @return \Illuminate\Http\Response
     */
    public function show(EmailConfirmation $emailConfirmation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmailConfirmation  $emailConfirmation
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailConfirmation $emailConfirmation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EmailConfirmation  $emailConfirmation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmailConfirmation $emailConfirmation)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmailConfirmation  $emailConfirmation
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailConfirmation $emailConfirmation)
    {
        //
    }

    public function confirmationEmail($uid,$id)
    {
            
            $data=User::find($id);
            echo $data;
            $data1=EmailConfirmation::where('id_usuario',$data->id)->first();
            //$data1->fecha_hora=Carbon::now();
            $fecha_actual=Carbon::now(new \DateTimeZone('America/La_Paz'));
            $fecha_registro=Carbon::parse($data1->fecha_hora);
            $cantidadMinutos = $fecha_actual->diffInMinutes($fecha_registro);
            echo $cantidadMinutos." ".$fecha_actual. " ". $fecha_registro;
            if($cantidadMinutos<10000){
                if ($data->estado_confirmacion=="false") {
                    return view('mail.view_confirmacion',["id_usuario"=>$id,"uid"=>$uid]);
                }else{
                    return view('mail.ya_confirmado',["email"=>$data->email]);
                }
            }else{
                return view('mail.tiempo_excedido');
            }
            
            

            

    }

    public function confirmationRegister($uid,$id)  
    {
        $data=User::find($id)->first();
        $data->estado_confirmacion="true";
        $data->save();

        //$data1=EmailConfirmation::where('id_usuario',$data->id)->first();
        //$data1->fecha_hora=Carbon::now();
            
        return view('mail.ya_confirmado',["email"=>$data->email]);

    }
}
