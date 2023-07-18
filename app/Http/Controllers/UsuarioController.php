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
use App\Models\DenunciaEstado;
use App\Models\Area;
use App\Models\DenunciaFoto;



use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsuarioController extends Controller
{

    public function storeToken(Request $request)
    {
        auth()->user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }

    function sendWebNotification(Request $request) {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
          
        $serverKey = 'AAAAqCHzXSk:APA91bHatb4qMLDE8Sgr28uf_WhSl9YR11eoVyY3NSVB-jgzaudG-iPR73UeOwU76d6JsD41pwQdSXwGPZkGFGIre4QHhSZVfCcPoqTKp0CHo7wswL1N8dBzM0AU3sIKjkc_tFVLebJe';
  
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,  
            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response
        return $result;
    }


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
        $area=Area::find($funcionario->id_area);
        return view('mainPage',['usuario'=>$data,'persona'=>$persona,'area'=>$area]);
    }

    function logout() {
        Auth::logout();
        return redirect()->route('welcome');
    }

    function info_denuncia($id) {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $denuncia=Denuncia::find($id);
        $tipo=DenunciaTipo::find($denuncia->id_tipo);
        $area=Area::find($tipo->id_area);
        $estado=DenunciaEstado::find($denuncia->id_estado);
        
        $estados=DenunciaEstado::all();
        $foto=DenunciaFoto::where('id_denuncia',$denuncia->id)->first();
        return view('denuncias_funcionario.info_denuncia',['usuario'=>$data,'persona'=>$persona,'tipo'=>$tipo,'area'=>$area,'denuncia'=>$denuncia, 'estado'=>$estado, 'estados'=>$estados,'foto'=>$foto]); 
    }

    function cambiarEstadoDenuncia(Request $request) {
        $data=Denuncia::find($request->id_denuncia);
        $data->id_estado=$request->id_estado;
        $data->save();
        return "exito";
    }
    function lista_denuncias() {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $area=DenunciaTipo::find($funcionario->id_area);
        $tipo=new DenunciaTipoController();
        $estado=new DenunciaEstadoController();
        $denuncias=Denuncia::select('denuncias.*', 'denuncia_fotos.url as denuncia_image','denuncia_estados.nombre as nombre_estado')
                    ->leftJoin('denuncia_fotos', 'denuncia_fotos.id_denuncia', 'denuncias.id')
                    ->leftJoin('denuncia_estados', 'denuncia_estados.id', 'denuncias.id_estado')
                    ->latest()->paginate(8);

        return view('denuncias_funcionario.lista_Denuncias',['usuario'=>$data,'persona'=>$persona,'area'=>$area,'denuncias'=>$denuncias,"tipos"=>$tipo->tiposXarea($area->id),"estados"=>$estado->index()]);
    }

    function getFiltro(Request $request) {
        $user=Auth::user();
        $persona=Persona::find($user->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $area=DenunciaTipo::find($funcionario->id_area);
        $tipo=new DenunciaTipoController();
        $estado=new DenunciaEstadoController();
        $data=Denuncia::select('denuncias.*', 'denuncia_estados.nombre as nombre_estado',
                                'denuncia_tipos.nombre as nombre_tipo','denuncia_fotos.url as denuncia_image')
                    ->leftJoin('denuncia_fotos', 'denuncia_fotos.id_denuncia', 'denuncias.id')
                    ->join("denuncia_estados","denuncia_estados.id","denuncias.id_estado")
                    ->join("denuncia_tipos","denuncia_tipos.id","denuncias.id_tipo");

        if ($request->opciones_tipo!='' && $request->opciones_tipo!='0') {
            $data=$data->where("denuncias.id_tipo",$request->opciones_tipo);
        }
        if($request->opciones_estado!='' && $request->opciones_estado!='0'){
            $data=$data->where("denuncias.id_estado",$request->opciones_estado);
        }
        if ($request->opciones_periodo!='' && $request->opciones_periodo!='0') {
            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $end_date=$date->subDays($request->opciones_periodo);
            $data=$data->where("denuncias.fecha_creacion", '>=',$end_date);
        }
        $denuncias=$data->latest()->paginate(8);
        return view('denuncias_funcionario.lista_Denuncias',['usuario'=>$user,'persona'=>$persona,'area'=>$area,'denuncias'=>$denuncias,"tipos"=>$tipo->tiposXarea($area->id),"estados"=>$estado->index()]);
    }
    

    function lista_areas() {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $area=Area::find($funcionario->id_area);
       
        $areas= DB::table('areas')->paginate(10);;
        return view('denuncia_areas.lista_areas',['usuario'=>$data,'persona'=>$persona,'area'=>$area,'areas'=>$areas]);
    }

    function lista_funcionarios() {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $area=Area::find($funcionario->id_area);
        $areas=Area::all();
        $funcionarios=Funcionario::select('funcionarios.*', 'personas.*','users.*','areas.nombre as nombre_area')
            ->leftJoin('personas', 'personas.id', 'funcionarios.id_persona')
            ->leftJoin('areas', 'areas.id', 'funcionarios.id_area')
            ->join("users","users.id_persona","personas.id")->paginate(8);
        return view('funcionarios.lista_funcionarios',['usuario'=>$data,'persona'=>$persona,'area'=>$area,'funcionarios'=>$funcionarios,'areas'=>$areas]);
        }

        function mapa_funcionario() {
            $data=Auth::user();
            $persona=Persona::find($data->id_persona);
            $funcionario=Funcionario::where('id_persona',$persona->id)->first();
            $area=Area::find($funcionario->id_area);
            $denuncias= new DenunciaController();
            $tipo=new DenunciaTipoController();
            $estado=new DenunciaEstadoController();
            return view('funcionarios.mapa_funcionario',['usuario'=>$data,'persona'=>$persona,'area'=>$area,"login"=>true,"dashboard"=>true,"denuncias"=>$denuncias->index(),"tipos"=>$tipo->index(),"estados"=>$estado->index()]);
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

    function settings() {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $area=Area::find($funcionario->id_area);
        return view('update_periodos',['usuario'=>$data,'persona'=>$persona,'area'=>$area,'funcionario'=>$funcionario]); 
    }

//Route::get('/', function () {
//    return view('update_periodos');
//})->name('form');


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
        $data->password = bcrypt($request->password);
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
