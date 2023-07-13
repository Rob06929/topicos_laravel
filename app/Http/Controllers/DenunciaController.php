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
            'descripcionInapropiada'=> false,//2= si la descripcion inapropiada, 3= descripcion no coincide con denuncia
            'imageCoincide'=> false,//si la imagen no coincide se envia true
            'descripcionCoincide'=> false,
            'msgImage'=> 'La imagen no coincide con el tipo de denuncia',
            'msgDescription'=> 'La descripcion no coincide con el tipo de denuncia',
        ];
        //validamos que la descripcion no tenga nada inapropiado
        $validation= $this->moderacionContenido($request);
        $message["a"]=$validation;
        if($validation['descripcion']=='true'){//si devuelve false, es por que tiene cosas indebidas
            $message['descripcionInapropiada']=true;
            return $message;
        }
        // return $validation;
        //********************** realiza la comparacion con el tipo */
        $data=$this->compararContenidoImagen($request);
    
        // return $data;
        $message["b"]=$data;

        if($data['imagen']=='true'){//true=tiene relacion tipo con imagen
            $message['imageCoincide']=true;
        }
        if($data['descripcion']=='true'){//true=tiene relacion tipo con descripcion
            $message['descripcionCoincide']=true;
        }
        if($message['imageCoincide']==false || $message['descripcionCoincide']==false){
            return $message;
        }
        // fin de la comparacion con tipo de denuncia
        // return $request;
        if ($request->hasFile('image')) {
            /*$extension  = request()->file('image')->getClientOriginalExtension(); //This is to get the extension of the image file just uploaded
            $image_name = time() .'_foto.' . $extension;
            // return $image_name;
            $path = $request->file('image')->storeAs(
                'images',
                $image_name,
                's3'
            );*/
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
            $data_img="https://ex-software1.s3.amazonaws.com/images/1686076077_foto.jpg";//$saveImg->store("https://ex-software1.s3.amazonaws.com/".$path,$data->id);
            //echo $data_img->url;
            return 'exito';
        }
        return 'error';
    }

    public function moderacionContenido(Request $request)
    {
        //$arrayStatus = array('status' => 'exito','titulo'=>'true','descripcion'=>'true','');
        $arrayStatus = array('status' => 'exito','descripcion'=>'false');

        $chat=new ChatController();
        /*$messageTit=$chat->chatModeracion($request->titulo);
        if ($this->noModerado($messageTit)) {
            $arrayStatus['titulo']="false";
        }*/
        $messageDes=$chat->chatModeracion($request->descripcion);
        echo "llega aqui";

        if ($this->noModerado($messageDes)) {
            $arrayStatus['descripcion']="true";
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
            $lista['contexto']=$scan_img['caption']['text'];
            // return $scan_img;
            //echo $scan_img;
            //$lista["res_img"]=$scan_img["caption_GPTS"];
            //$lista["res_img2"]=$scan_img->caption_GPTS;
            $inst2=new ChatController();
            $comparacion1=$inst2->compararTextoTipo($scan_img['caption_GPTS']['text'],$request->type_name);
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

    public function getFiltroMap(Request $request)
    {


        $data=Denuncia::select('denuncias.*', 'denuncia_estados.nombre as nombre_estado',
                                'denuncia_tipos.nombre as nombre_tipo')
                    ->join("denuncia_estados","denuncia_estados.id","denuncias.id_estado")
                    ->join("denuncia_tipos","denuncia_tipos.id","denuncias.id_tipo");
        if ($request->type_id!='' && $request->type_id!='0') {
            $data=$data->where("denuncias.id_tipo",$request->type_id);
        }
        if($request->state_id!='' && $request->state_id!='0'){
            $data=$data->where("denuncias.id_estado",$request->state_id);
        }
        if ($request->num_days!='' && $request->num_days!='0') {
            $carbon = new \Carbon\Carbon();
            $date = $carbon->now();
            $end_date=$date->subDays($request->num_days);
            $data=$data->where("denuncias.fecha_creacion", '>=',$end_date);
        }
        $data=$data->get();

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
