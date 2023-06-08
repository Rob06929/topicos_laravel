<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiImageController extends Controller
{
    public $asticaAPI_key = '0739FFE1-6FB2-4A65-9BC5-F786E97B2777B94341CC-0B60-4F4B-A5D0-F30635144680'; //visit https://astica.org
    public $asticaAPI_timeout = 60; // seconds  Using "gpt" or "gpt_detailed" will increase response time.

    public $asticaAPI_endpoint = 'https://www.astica.org:9141/vision/describe';
    public $asticaAPI_modelVersion = '2.0_full';  //1.0_full or 2.0_full  

    public $asticaAPI_input = 'https://ex-software1.s3.amazonaws.com/detalle-shot-rota-con-una-lampara-de-la-calle-con-el-cielo-nublado-al-fondo-f5cnhd.jpg'; //or base64 encoded string: data:image/png;base64,iVBORw0KG.....
    public $asticaAPI_visionParams = 'gpt, description, objects, faces'; //comma separated options; leave blank for all; note "gpt" and "gpt_detailed" are slow.


    function img_enc_base64 ($filepath){   // img_enc_base64() is manual function you can change the name what you want.

        if (file_exists($filepath)){
            $get_img = file_get_contents($filepath);
            return 'data:image/jpg;base64,' . base64_encode($get_img );
        }
    }

    public function analizeImage($img)  
    {
        $asticaAPI_payload = [
            'tkn' => $this->asticaAPI_key,
            'modelVersion' =>$this->asticaAPI_modelVersion,
            'visionParams' => $this->asticaAPI_visionParams,
            'input' =>$this->img_enc_base64("images/".$img),
        ];
        $result = $this->asticaAPI($this->asticaAPI_endpoint, $asticaAPI_payload, $this->asticaAPI_timeout);
        return json_encode($result);
    }

    public function asticaAPI($endpoint, $payload, $timeout = 15)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $endpoint,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_TIMEOUT => $timeout
        ]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);        
        $result = json_decode($response, true);
        echo $response;
        if(!isset($result['status'])) {
                       

            $result = $response['caption_GPTS'];
        }
        return $result;
    }
}   
