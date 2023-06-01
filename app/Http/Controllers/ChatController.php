<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function chatModeracion($message)
    {
        
  
        $data = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
                  ])
                  ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-3.5-turbo",
                    'messages' => [
                        ['role' => 'system', 'content' => 'si el mensaje contiene insultos responde solo verdadero caso contrario responde falso '],
                        [
                           "role" => "user",
                           "content" =>'"'.$message.'"',
                        ],
                        ['role' => 'assistant', 'content' => '👍']
                    ],
                    'temperature' => 0.5,
                    "max_tokens" => 200,
                    "top_p" => 1.0,
                    "frequency_penalty" => 0.52,
                    "presence_penalty" => 0.5,
                    "stop" => ["11."],
                  ])
                  ->json();
  
        return $data['choices'][0]['message']['content'];
 
    }

    public function verificacionTituloAPI(Request $request)  
    {
      $data = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
      ])
      ->post("https://api.openai.com/v1/chat/completions", [
        "model" => "gpt-3.5-turbo",
        'messages' => [
            ['role' => 'system', 'content' =>'el siguiente mensaje esta relacionado con las siguientes categorias: '.$request->categories.' .Caso contrario devuelve falso'],
            [
               "role" => "user",
               "content" => $request->message,
            ],
            ['role' => 'assistant', 'content' => '👍']
        ],
        'temperature' => 0.5,
        "max_tokens" => 200,
        "top_p" => 1.0,
        "frequency_penalty" => 0.52,
        "presence_penalty" => 0.5,
        "stop" => ["11."],
      ])
      ->json();

      return response()->json($data['choices'][0]['message'], 200, array(), JSON_PRETTY_PRINT);
    }

    public function verificacionTitulo($message)  
    {
      $data = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
      ])
      ->post("https://api.openai.com/v1/chat/completions", [
        "model" => "gpt-3.5-turbo",
        'messages' => [
            ['role' => 'system', 'content' =>'el siguiente mensaje esta relacionado con las siguientes categorias: '.$request->categories.' .Caso contrario devuelve falso'],
            [
               "role" => "user",
               "content" => $message,
            ],
            ['role' => 'assistant', 'content' => '👍']
        ],
        'temperature' => 0.5,
        "max_tokens" => 200,
        "top_p" => 1.0,
        "frequency_penalty" => 0.52,
        "presence_penalty" => 0.5,
        "stop" => ["11."],
      ])
      ->json();

      return $data['choices'][0]['message'];
    }

    public function verificacionDescripcion($message)  
    {
      $data = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
      ])
      ->post("https://api.openai.com/v1/chat/completions", [
        "model" => "gpt-3.5-turbo",
        'messages' => [
            ['role' => 'system', 'content' =>'el siguiente mensaje esta relacionado con las siguientes categorias: '.$request->categories.' .Caso contrario devuelve falso'],
            [
               "role" => "user",
               "content" => $message,
            ],
            ['role' => 'assistant', 'content' => '👍']
        ],
        'temperature' => 0.5,
        "max_tokens" => 200,
        "top_p" => 1.0,
        "frequency_penalty" => 0.52,
        "presence_penalty" => 0.5,
        "stop" => ["11."],
      ])
      ->json();

      return $data['choices'][0]['message'];
    }
}
