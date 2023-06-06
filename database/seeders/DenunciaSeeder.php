<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenunciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 1',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '17-04-2023',
            'latitud' => '-1123234',
            'longitud' => '-234543',
            'id_usuario'=>1,
            'id_estado'=>1,
            'id_tipo'=>1,
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 2',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '17-04-2023',
            'latitud' => '-1123234',
            'longitud' => '-234543',
            'id_usuario'=>1,
            'id_estado'=>2,
            'id_tipo'=>2
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 3',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '17-04-2023',
            'latitud' => '-1123234',
            'longitud' => '-234543',
            'id_usuario'=>1,
            'id_estado'=>1,
            'id_tipo'=>2
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 4',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '17-04-2023',
            'latitud' => '-1123234',
            'longitud' => '-234543',
            'id_usuario'=>1,
            'id_estado'=>3,
            'id_tipo'=>3
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 5',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '17-04-2023',
            'latitud' => '-1123234',
            'longitud' => '-234543',
            'id_usuario'=>1,
            'id_estado'=>2,
            'id_tipo'=>2
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 6',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '17-04-2023',
            'latitud' => '-1123234',
            'longitud' => '-234543',
            'id_usuario'=>1,
            'id_estado'=>1,
            'id_tipo'=>1
        ]);
    }
}
