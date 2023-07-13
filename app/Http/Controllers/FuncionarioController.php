<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Persona;
use App\Models\User;
use App\Models\Area;
use Illuminate\Support\Facades\Crypt;


use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function indexAdmin(){
        return view('mainPage');
    }

    
    public function index()
    {
        return view('mainPage');
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

        if ($request->hasFile('file_foto')) {

            $persona=new Persona();

            $persona->nombre=$request->nombre;
            $persona->telefono=$request->celular;
            $persona->direccion=$request->direccion;
            $persona->ci=$request->ci;
            $persona->save();

            $data=new Funcionario();
            $data->codigo="ASD345";
            $data->id_area=$request->id_area;
            $data->id_persona=$persona->id;
            $data->save();

            $extension  = request()->file('file_foto')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
            $image_name = time() .'_foto.' . $extension;
            // return $image_name;
            $path = $request->file('file_foto')->storeAs(
                'images',
                $image_name,
                's3'
            );

            $user=new User();
            $user->name=$request->usuario;
            $user->email=$request->email;
            $user->estado_confirmacion="false";
            $user->password=bcrypt($request->password);
            $user->url_foto="https://ex-software1.s3.amazonaws.com/".$path;
            $user->id_persona=$persona->id;
            $user->save();
            return redirect()->route('lista_funcionarios');
        }   
        return "error";

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function show(Funcionario $funcionario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=Auth::user();
        $persona=Persona::find($data->id_persona);
        $funcionario=Funcionario::where('id_persona',$persona->id)->first();
        $area=Area::find($funcionario->id_area);
        $areas=Area::all();
        $funcionario=Funcionario::select('funcionarios.*', 'personas.*','users.*','areas.nombre as nombre_area','areas.id as id_area')
            ->leftJoin('personas', 'personas.id', 'funcionarios.id_persona')
            ->leftJoin('areas', 'areas.id', 'funcionarios.id_area')
            ->join("users","users.id_persona","personas.id")
            ->where('users.id',$id)->first();
        return view('funcionarios.perfil_funcionario' ,['usuario'=>$data,'persona'=>$persona,'area'=>$area,'funcionario'=>$funcionario,'areas'=>$areas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

            $user=User::where('id',$id)->first();
            $user->name=$request->usuario;
            $user->email=$request->email;
            if ($request->password!="") {
                $user->password=bcrypt($request->password);
            }
            if ($request->hasFile('file_foto')) {
                $extension  = request()->file('file_foto')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
                $image_name = time() .'_foto.' . $extension;
                // return $image_name;
                $path = $request->file('file_foto')->storeAs(
                    'images',
                    $image_name,
                    's3'
                );
                $user->url_foto="https://ex-software1.s3.amazonaws.com/".$path;
            }
            $user->save();

            $persona=Persona::where('id',$user->id_persona)->first();
            $persona->nombre=$request->nombre;
            $persona->telefono=$request->celular;
            $persona->direccion=$request->direccion;
            $persona->ci=$request->ci;
            $persona->save();
            echo $persona;
            $data=Funcionario::where('id_persona',$persona->id)->first();
            $data->id_area=$request->id_area;
            echo $data;
            $data->save();
            return redirect()->route('lista_funcionarios');         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Funcionario  $funcionario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Funcionario $funcionario)
    {
        //
    }
}
