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
        // return Denuncia::select('denuncias.*',
        //                         'denuncia_estados.nombre as nombre_estado',
        //                         'denuncia_tipos.nombre as nombre_tipo'
        //                         )
        //             ->join("denuncia_estados","denuncia_estados.id","denuncias.id_estado")
        //             ->join("denuncia_tipos","denuncia_tipos.id","denuncias.id_tipo")
        //             ->get();

        $data=Denuncia::select('*', 'denuncia_estados.nombre as nombre_estado',
                            'denuncia_tipos.nombre as nombre_tipo')
                    ->join("denuncia_estados","denuncia_estados.id","denuncias.id_estado")
                    ->join("denuncia_tipos","denuncia_tipos.id","denuncias.id_tipo")
                    ->get();
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
        // return $request;
        // return $request->hasFile('image');
        $message=[
            'descripcionInapropiada'=> 1,//2= si la descripcion inapropiada, 3= descripcion no coincide con denuncia
            'imageNoCoincide'=> 'false',//si la imagen no coincide se envia true
            'messageDescripcion'=> 'Tiene contenido inapropiado*',
            'msgImage'=> 'La imagen no coincide con el tipo de denuncia',
            'msgDescription'=> 'La descripcion no coincide con el tipo de denuncia',
        ];
        //validamos que la descripcion no tenga nada inapropiado
        $validation= $this->moderacionContenido($request);
        if($validation['descripcion']=='false'){//si devuelve false, es por que tiene cosas indebidas
            $message['descripcionInapropiada']=2;
            return $message;
        }
        // return $validation;
        //********************** realiza la comparacion con el tipo */
        $data=$this->compararContenidoImagen($request);
        // return $data;
        if($data['imagen']=='false'){//true=tiene relacion tipo con imagen
            $message['imageNoCoincide']='true';
        }
        if($data['descripcion']=='false'){//true=tiene relacion tipo con descripcion
            $message['descripcionInapropiada']=3;
        }
        if($message['imageNoCoincide']=='true' || $message['descripcionInapropiada']==3){
            return $message;
        }
        // fin de la comparacion con tipo de denuncia
        // return $request;
        if ($request->hasFile('image')) {
            $extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
            $image_name = time() .'_foto.' . $extension;
            // return $image_name;
            $path = $request->file('image')->storeAs(
                'images',
                $image_name,
                's3'
            );
            // return 'xd' ;
            $data=new Denuncia;
            $data->titulo=$request->title;
            $data->descripcion=$request->descripcion;
            $data->fecha_creacion=Carbon::now();
            $data->latitud=$request->latitud;
            $data->longitud=$request->longitud;
            $data->id_tipo=$request->type_id;
            $data->id_estado=1;
            $data->id_usuario=$request->id_usuario;
            $data->save();
            // return 'xd' ;
            $saveImg=new DenunciaFotoController;
            $data_img=$saveImg->store("https://ex-software1.s3.amazonaws.com/".$path,$data->id);
            return "exito";
            //echo $data_img->url;
        }
        return 'error';
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
        $messageDes=$chat->chatModeracion($request->descripcion);
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
            // return $scan_img;
            //echo $scan_img;
            //$lista["res_img"]=$scan_img["caption_GPTS"];
            //$lista["res_img2"]=$scan_img->caption_GPTS;
            $inst2=new ChatController();
            $comparacion1=$inst2->compararTextoTipo($scan_img,$request->type_name);
            $lista["com_img"]=$comparacion1;
            $comparacion2=$inst2->compararTextoTipo($request->descripcion,$request->type_name);
            $lista["com_desc"]=$comparacion2;
            if ($this->containTrue($comparacion1['content'])) {
                $lista["imagen"]="true";
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
        if (strpos($mensaje, 'true')!== false || strpos($mensaje, 'True.')!== false || strpos($mensaje, 'True')!== false || strpos($mensaje, 'True,')!== false) {
            return true;
        }
        return false;
    }

    public function containTrue($mensaje)
    {

        if (strpos($mensaje, 'true')!== false || strpos($mensaje, 'True.')!== false || strpos($mensaje, 'True')!== false || strpos($mensaje, 'True,')!== false) {
            return true;
        }

        return false;
    }

    public function getFiltro(Request $request)
    {

        $data=Denuncia::select('denuncias.*', 'denuncia_estados.nombre as nombre_estado',
                            'denuncia_tipos.nombre as nombre_tipo')
                    ->join("denuncia_estados","denuncia_estados.id","denuncias.id_estado")
                    ->join("denuncia_tipos","denuncia_tipos.id","denuncias.id_tipo");
        if ($request->type_id!='') {
                $data=$data->where("denuncias.id_tipo",$request->type_id);
        }
        if($request->state_id!=''){
            $data=$data->where("denuncias.id_estado",$request->state_id);
        }
        if ($request->date_finish!='') {
            $data=$data->where("denuncias.fecha_creacion", '<=',$request->date_finish);
        }
        if($request->date_init!=''){
            $data=$data->where("denuncias.fecha_creacion", '>=', $request->date_init);
        }
        $data=$data->get();
        foreach ($data as $value) {
            $value->url=DenunciaFotoController::getFoto($value->id)->url;
        }
        return $data;
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


    public function updateDenuncia(Request $request)
    {   
        if ($request->hasFile('image')) {
            

            if ($request->modificado_imagen=="true") {
                $extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
                $image_name = time() .'_foto.' . $extension;
                $path = $request->file('image')->storeAs(
                    'images',
                    $image_name,
                    's3'
                );
            }
           
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
            return "exito";
            //echo $data_img->url;
        }
    }


}
