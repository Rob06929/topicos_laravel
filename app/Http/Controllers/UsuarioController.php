<?php

namespace App\Http\Controllers;

use App\Models\IntentosFallidos;
use App\Models\Fucionario;
use App\Models\Vecino;
use App\Models\EmailConfirmation;
use App\Models\User;
use App\Models\Persona;
use App\Models\FailsPassword;
use App\Http\Controllers\FailsPasswordController;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\UpdatePassword;
use App\Models\Usuario;
use App\Models\Funcionario;
use App\Models\Denuncia;
use App\Models\DenunciaTipo;
use App\Models\Area;


use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;



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

    function login(Request $request) {        
        if (Auth::attempt(['email' => $request->email,  'password' => $request->password])) {            
            return redirect()->route('inicio');
        }
        return redirect()->route('login');
    }


    function inicio() {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $tipo=DenunciaTipo::find($funcionario->id_area);

        return view('mainPage',['usuario'=>$data,'persona'=>$persona,'tipo'=>$tipo]);
    }

    function logout() {
        Auth::logout();
        return redirect()->route('welcome');
    }

    function lista_denuncias() {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $tipo=DenunciaTipo::find($funcionario->id_area);
        $denuncias=Denuncia::select('denuncias.*', 'denuncia_fotos.url as denuncia_image')
                    ->leftJoin('denuncia_fotos', 'denuncia_fotos.id_denuncia', 'denuncias.id')
                    ->latest()->paginate(10);

        return view('denuncias_funcionario.lista_Denuncias',['usuario'=>$data,'persona'=>$persona,'tipo'=>$tipo,'denuncias'=>$denuncias]);
    }

    function lista_areas() {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $tipo=DenunciaTipo::find($funcionario->id_area);
        $areas=Area::all();
        return view('denuncia_areas.lista_areas',['usuario'=>$data,'persona'=>$persona,'tipo'=>$tipo,'areas'=>$areas]);
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
        $ref=new FailsPasswordController();
        $ref->update($data->id);
        $fail=$ref->show($data->id);
        if ($fail->intentos<3) {
            if ($data != null) {
                if ($data->password == $request->contraseña) {
                    $ref->reset($data->id);
                   $msg['id'] = $data->id;
                   return json_encode($msg);
   
                } else {
                    $resp=$ref->store($data->id);
                    $msg['resp'] = 0;
                    if ($resp=="block") {
                        return json_encode("block");
                    }
                    return json_encode($msg);
                   
                }
           }
        }else{
            return json_encode("block");
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

        $data4=new FailsPassword();
        $data4->intentos=0;
        $data4->id_usuario=$data->id;
        $data4->save();
        
        return json_encode(["response" => "exito",
                            "id"=> $data->id]);
        $data3 = array('nombre' => $data1->nombre, 'uid' => $data2->uid, 'id' => $data->id,);
        $to_email = $data->email;
        $to_name = $data1->nombre;
        Mail::send('mail.confirmacion', $data3, function ($message) use ($to_email, $to_name) {

            $message->to($to_email, $to_name)->subject('ALCALDIA - Confirmación de correo');
            $message->from('robfernandez06929@gmail.com', 'Alcaldia');
        });

        return json_encode(["response" => "exito",
                            "id"=> $data->id]);
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
        // return($request);
        return ($data->estado_confirmacion);
    }


    
}
