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
                    'Authorization' => 'Bearer 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',
                  ])
                  ->post("https://api.openai.com/v1/chat/completions", [
                    "model" => "gpt-3.5-turbo",
                    'messages' => [
                        ['role' => 'system', 'content' => 'si el mensaje contiene insultos responde estrictamente solo "true" caso contrario responde "false" '],
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
            ['role' => 'system', 'content' =>'eres un bot que analiza descripciones de denuncias en una ciudad y determina si los siguientes mensajes entran dentro de las categorias de '.$request->categories.' o contienen alguna palabra relacionada a ella, debes responder estrictamente solo la palabra "true" si esta relacionado o "false" caso contrario'],
            [
               "role" => "user",
               "content" =>'"'.$request->message.'"',
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

    public function verificacionTitulo($message,$tipo)  
    {
      $data = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
      ])
      ->post("https://api.openai.com/v1/chat/completions", [
        "model" => "gpt-3.5-turbo",
        'messages' => [
            ['role' => 'system', 'content' =>'eres un bot que analiza descripciones de denuncias en una ciudad y determina si los siguientes mensajes entran dentro de la categoria de '.$tipo.' o contienen alguna palabra relacionada a ella, estrictamente debes responder solo la palabra "true" si esta relacionado o "false" caso contrario'],
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

      return $data['choices'][0]['message'];
    }

    public function verificacionDescripcion($message,$tipo)  
    {
      $data = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer '.env('OPENAI_API_KEY'),
      ])
      ->post("https://api.openai.com/v1/chat/completions", [
        "model" => "gpt-3.5-turbo",
        'messages' => [
            ['role' => 'system', 'content' =>'eres un bot que analiza descripciones de denuncias en una ciudad y determina si el siguiente mensaje entra dentro de la categoria de '.$tipo.' o contienen alguna palabra relacionada a ella, estrictamente debes responder solo una palabra "true" si esta relacionado o "false" caso contrario'],
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

    public function compararTextoTipo($message1,$tipo)  
    {
      $data = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer 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',
      ])
      ->post("https://api.openai.com/v1/chat/completions", [
        "model" => "gpt-3.5-turbo",
        'messages' => [
            ['role' => 'system', 'content' =>'eres un bot que analiza denuncias en una ciudad y determina si entran dentro de la categoria de '.$tipo.' o contienen alguna palabra relacionada a ella, estrictamente debes responder solo la palabra "true" si esta relacionado o "false" caso contrario'],
            [
               "role" => "user",
               "content" =>'texto 1: "'.$message1,
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
