<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;

class DenunciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Denuncia::where("id_usuario",$id)->get();
        return json_encode(Denuncia::all());
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
        $arrayStatus = array('status' => 'exito','titulo'=>'true','descripcion'=>'true','');
        
            $chat=new ChatController();
            $messageTit=$chat->chatModeracion($request->titulo);
            if ($this->noModerado($messageTit)) {
                $arrayStatus['titulo']="titulo no moderado";
            }
            $messageDes=$chat->chatModeracion($request->descripcion);
            if ($this->noModerado($messageDes)) {
                $arrayStatus['descripcion']="descripcion no moderada";
            }
            return $arrayStatus;
      
    }

    public function moderacionContenido(Request $request)
    {
        $arrayStatus = array('status' => 'exito','titulo'=>'true','descripcion'=>'true','');
        
        $chat=new ChatController();
        $messageTit=$chat->chatModeracion($request->titulo);
        if ($this->noModerado($messageTit)) {
            $arrayStatus['titulo']="titulo no moderado";
        }
        $messageDes=$chat->chatModeracion($request->descripcion);
        if ($this->noModerado($messageDes)) {
            $arrayStatus['descripcion']="descripcion no moderada";
        }
        return $arrayStatus;
    }

    public function compararContenidoImagen(Request $request)
    {


        /*if ($request->hasFile('image')) {
            $extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
            $image_name = time() .'_ foto.' . $extension;
            $path = $request->file('image')->storeAs(
                'images',
                $image_name,
                's3'
            );
            
            return $path;
        }*/
        $extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
        $image_name = time() .'_ foto.' . $extension;
        $image = $request->file('image')->move('images/', $image_name);
        $inst1=new ApiImageController;
        $scan_img=$inst1->analizeImage($image_name);
        return $scan_img;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Denuncia  $denuncia
     * @return \Illuminate\Http\Response
     */
    public function show(Denuncia $denuncia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Denuncia  $denuncia
     * @return \Illuminate\Http\Response
     */
    public function edit(Denuncia $denuncia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Denuncia  $denuncia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Denuncia $denuncia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Denuncia  $denuncia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Denuncia $denuncia)
    {
        //
    }

    public function noModerado($mensaje)
    {
        if (strpos($mensaje, 'verdadero')>=0) {
            return true;
        }
        return false;
    }

    public function getFiltro(Request $request)
    {
        if ($request->tipo_denuncia) {
            if ($request->estado_denuncia) {
               
                $data=Denuncia::where("id_tipo",$request->tipo_denuncia)->where("id_estado",$request->estado_denuncia)->get();
            }else{
                echo "bbbbb";
                $data=Denuncia::where("id_tipo",$request->tipo_denuncia)->get();
            }
            return json_encode($data);    
        }else{
            if ($request->estado_denuncia) {
                $data=Denuncia::where("id_estado",$request->estado_denuncia)->get();
                return json_encode($data);    

            }else{
                return $this->index();
            }
            
        }
        
    }

    public function getTipoEstado()
    {
        $tipo=new DenunciaTipoController;
        $estado=new DenunciaTipoController;

        $arr=array();
        $arr['tipo']=$tipo->index();
        $arr['estado']=$estado->index();
        return $arr;
    }

}
