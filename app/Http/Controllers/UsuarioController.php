<?php

namespace App\Http\Controllers;

use App\Models\IntentosFallidos;
use App\Models\Fucionario;
use App\Models\Vecino;
use App\Models\EmailConfirmation;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\UpdatePassword;
use App\Models\Usuario;
use Carbon\Carbon;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsuarioController extends Controller
{

    public function save(Request $request)
    {

        try {
            $data_persona = new Persona();

            $data_persona->nombre = $request->nombre;
            $data_persona->telefono = $request->telefono;
            $data_persona->direccion = $request->direccion;
            $data_persona->ci = $request->ci;
            $data_persona->save();

            $data_usaurio = $request->user_name;
            $data_usaurio = $request->email;
            $data_usaurio = bcrypt($request->password);
            $data_usaurio->estado_confirmacion = "false";
            $data_usaurio->url_foto = $request->url_foto;
            $data_usaurio->id_persona = $data_persona->id;
            return json_encode("200");
        } catch (\Throwable $th) {
            return json_encode("500");
        }
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
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $data = User::find($id);
        $data1= Persona::find($data->id_persona);

        return json_encode(["usuario"=>$data->name,"telefono"=>$data1->telefono,"ci"=>$data1->ci,"direccion"=>$data1->direccion,"email"=>$data->email,"nombre"=>$data1->nombre]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data =User::find($id);
        $data->name = $request->nombre_usuario;
        //$data->email = $request->email;
        $data->save();

        $data1 =Persona::find($data->id_persona);
        $data1->telefono = $request->telefono;
        $data1->direccion = $request->direccion;
        $data1->save();
        return json_encode("exito");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        //
    }

    public function get_data($name)
    {
        $data = User::where("name", $name)->first();
        return json_decode($data);
    }

    public function get_data_id($id)
    {
        $data = User::find($id);
        return json_decode($data);
    }

    public function apiLogin(Request $request)
    {
        // return $request;
        $msg=[
            'resp' => 1,
            'id' => 0
        ];
        $data = User::where("name", $request->name)->first();
        if ($data != null) {
             if ($data->password == $request->contraseña) {
                $msg['id'] = $data->id;
                return json_encode($msg);

             } else {
                $msg['resp'] = 0;
                return json_encode($msg);
             }
        }
       
    }





    public $data, $data1;
    public function apiSave(Request $request)
    {
        $data1 = new Persona;
        $data1->nombre = $request->nombre;
        $data1->telefono = $request->telefono;
        $data1->ci = $request->ci;
        $data1->direccion = $request->direccion;
        $data1->save();

        $data = new User;
        $data->name = $request->nombre_usuario;
        $data->email = $request->email;
        $data->estado_confirmacion = "false";
        $data->password = $request->password;
        $data->url_foto = $request->url_foto;
        $data->id_persona = $data1->id;
        $data->save();

        $data2 = new EmailConfirmation;
        $data2->uid = $this->generateRandomString(6);
        $data2->fecha_hora = Carbon::now(new \DateTimeZone('America/La_Paz'));
        $data2->id_usuario = $data->id;
        $data2->save();

        $data3 = array('nombre' => $data1->nombre, 'uid' => $data2->uid, 'id' => $data->id,);
        $to_email = $data->email;
        $to_name = $data1->nombre;
        Mail::send('mail.confirmacion', $data3, function ($message) use ($to_email, $to_name) {

            $message->to($to_email, $to_name)->subject('ALCALDIA - Confirmación de correo');
            $message->from('robfernandez06929@gmail.com', 'Alcaldia');
        });

        return json_encode(["response" => "exito"]);
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
    public function get_auth_email(Request $request)
    {
        $data = User::where("id", $request->id)->first();
        // dd($data);
        return ($data->estado_confirmacion);
    }
}
