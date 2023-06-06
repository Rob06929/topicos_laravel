<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        // return json_encode(Denuncia::all()->join("denuncia_estados","denuncia_estados.id","=","denuncia")->select("nombre")->get());
        $lista=array();
        $data=Denuncia::select('*', 'denuncia_estados.nombre as nombre_estado')
                    ->join("denuncia_estados","denuncia_estados.id","denuncias.id_estado")->get();
        foreach ($data as $value) {
            $value->url=DenunciaFotoController::getFoto($value->id)->url;
        }
        return $data;
        // return json_encode(Denuncia::select('denuncia.*', 'denuncia_estados.nombre')
        //                     ->join("denuncia_estados","denuncia_estados.id","=","denuncia.estado_id"));
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
        if ($request->hasFile('image')) {
            $extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
            $image_name = time() .'_foto.' . $extension;
            $path = $request->file('image')->storeAs(
                'images',
                $image_name,
                's3'
            );
            $data=new Denuncia;
            $data->titulo=$request->titulo;
            $data->descripcion=$request->descripcion;
            $data->fecha_creacion=Carbon::now();
            $data->latitud=$request->latitud;
            $data->longitud=$request->longitud;
            $data->id_tipo=$request->id_tipo;
            $data->id_estado=$request->id_estado;
            $data->id_usuario=$request->id_usuario;
            $data->save();

            $saveImg=new DenunciaFotoController;
            $data_img=$saveImg->store("https://ex-software1.s3.amazonaws.com/".$path,$data->id);

            echo $data_img->url;
        }
    }

    public function moderacionContenido(Request $request)
    {
        //$arrayStatus = array('status' => 'exito','titulo'=>'true','descripcion'=>'true','');
        $arrayStatus = array('status' => 'exito','descripcion'=>'true');
        
        $chat=new ChatController();
        /*$messageTit=$chat->chatModeracion($request->titulo);
        if ($this->noModerado($messageTit)) {
            $arrayStatus['titulo']="false";
        }*/
        return $messageDes=$chat->chatModeracion($request->descripcion);
        if ($this->noModerado($messageDes)) {
            $arrayStatus['descripcion']="false";
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
        $lista=array("imagen"=>"false","descripcion"=>"false","error"=>"true");

        if ($request->hasFile('image')) {
            $extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
            $image_name = time() .'_ foto.' . $extension;
            $image = $request->file('image')->move('images/', $image_name);
            $inst1=new ApiImageController;
            $scan_img=$inst1->analizeImage($image_name);
            //echo $scan_img;
            //$lista["res_img"]=$scan_img["caption_GPTS"];
            //$lista["res_img2"]=$scan_img->caption_GPTS;
            $inst2=new ChatController();
            $comparacion1=$inst2->compararTextoTipo($scan_img,$request->tipo);
            $lista["com_img"]=$comparacion1;
            $comparacion2=$inst2->compararTextoTipo($request->descripcion,$request->tipo);
            $lista["com_desc"]=$comparacion2;
            if ($this->containTrue($comparacion1['content'])) {
                $lista["descripcion"]="true";
            }
            if ($this->containTrue($comparacion2['content'])) {
                $lista["descripcion"]="true";
            }
           $lista["error"]="false";
        }
        return $lista; 

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
        if (strpos($mensaje, 'true')>=0 || strpos($mensaje, 'True.')>=0 || strpos($mensaje, 'True')>=0 || strpos($mensaje, 'True,')>=0) {
            return true;
        }
        return false;
    }

    public function containTrue($mensaje)
    {
        if (strpos($mensaje, 'true')>=0) {
            
            return true;
        }
        echo strpos($mensaje, 'true');
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
        $estado=new DenunciaEstadoController;

        $arr=array();
        $arr['tipo']=$tipo->index();
        $arr['estado']=$estado->index();
        return $arr;
    }

    public function cancelarDenuncia($id){
        $data=Denuncia::find($id);
        $data->id_estado=2;
        $data->save();
    }

}
