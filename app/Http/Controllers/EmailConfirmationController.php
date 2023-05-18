<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Mail;
use App\Models\Variable;


use App\Models\EmailConfirmation;
use Illuminate\Http\Request;

class EmailConfirmationController extends Controller
{

    public static function getPeriodoConfirmation()
    {
        $data=Variable::find(1);
        return $data->periodo_confirmacion;
    }   

    public static function setPeriodoConfirmation(Request $request)
    {
        $data=Variable::find(1);
        $data->periodo_confirmacion=$request->valor;
        $data->save();
        return redirect()->route('form');
    }

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
            $data2=Variable::find(1);
            
            $data=User::find($id);
            //echo $data;
            $data1=EmailConfirmation::where('id_usuario',$data->id)->first();
            //$data1->fecha_hora=Carbon::now();
            $fecha_actual=Carbon::now(new \DateTimeZone('America/La_Paz'));
            //$fecha_registro=Carbon::parse($data1->fecha_hora);
            $cantidadMinutos = $fecha_actual->diffInMinutes($data1->fecha_hora);
            //echo $cantidadMinutos." ".$fecha_actual. " ".$data1->fecha_hora;
            if($cantidadMinutos<$data2->periodo_confirmacion){
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
        $data=User::find($id);
        $data->estado_confirmacion="true";
        $data->save();

        //$data1=EmailConfirmation::where('id_usuario',$data->id)->first();
        //$data1->fecha_hora=Carbon::now();
            
        return view('mail.ya_confirmado',["email"=>$data->email]);

    }

    public function resendConfirmationEmail($id)
    {

        $data = User::find($id);

        $data1 =Persona::find($data->id_persona);

        $data2 = new EmailConfirmation;
        $data2->uid = $this->generateRandomString(6);
        $data2->fecha_hora = Carbon::now(new \DateTimeZone('America/La_Paz'));
        $data2->id_usuario = $data->id;
        $data2->save();
        // return $request;
        $data3 = array('nombre' => $data1->nombre, 'uid' => $data2->uid, 'id' => $data->id,);
        $to_email = $data->email;
        $to_name = $data1->nombre;
        Mail::send('mail.confirmacion', $data3, function ($message) use ($to_email, $to_name) {

            $message->to($to_email, $to_name)->subject('ALCALDIA - Confirmación de correo');
            $message->from('robfernandez06929@gmail.com', 'Alcaldia');
        });
        return json_encode("exito");
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        $randomString .= "z";
        return $randomString;
    }
}
