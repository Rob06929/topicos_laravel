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
            'fecha_creacion' => '04-07-2023',
            'latitud' => '-17.78629',
            'longitud' => '-63.18117',
            'id_usuario'=>1,
            'id_estado'=>1,
            'id_tipo'=>1,
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 2',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '02-07-2023',
            'latitud' => '-17.765539131640903',
            'longitud' => '-63.144001025059616',
            'id_usuario'=>1,
            'id_estado'=>2,
            'id_tipo'=>2
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 3',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '30-06-2023',
            'latitud' => '-17.797250540108326',
            'longitud' => '-63.2047691539485',
            'id_usuario'=>1,
            'id_estado'=>1,
            'id_tipo'=>2
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 4',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '29-06-2023',
            'latitud' => '-17.779270535525033',
            'longitud' => '-63.181079883364696',
            'id_usuario'=>1,
            'id_estado'=>3,
            'id_tipo'=>3
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 5',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '10-06-2023',
            'latitud' => '-17.798884996198442',
            'longitud' => '-63.150867480301294',
            'id_usuario'=>1,
            'id_estado'=>2,
            'id_tipo'=>2
        ]);
        DB::table('denuncias')->insert([
            'titulo' => 'titulo 6',
            'descripcion' => 'descripcion de la denuncia',
            'fecha_creacion' => '15-06-2023',
            'latitud' => '-17.776655111353374',
            'longitud' => '-63.194469471085974',
            'id_usuario'=>1,
            'id_estado'=>1,
            'id_tipo'=>1
        ]);
    }
}
