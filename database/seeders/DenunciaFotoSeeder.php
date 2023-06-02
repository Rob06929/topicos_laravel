<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenunciaFotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('denuncia_fotos')->insert([
            'url' => 'https://ex-software1.s3.amazonaws.com/antigua-calle-roto-luz-de-semaforo-y-sucio-persianas-desplegables-en-suburbio-ruinoso-deteriorado-barrio-residencial-urbano-2ajamew.jpg',
            'id_denuncia' => 1,
            
        ]);
        DB::table('denuncia_fotos')->insert([
            'url' => 'https://ex-software1.s3.amazonaws.com/BD4PPYFU2RDNHH4YQWZQ2LPDXI.jpg',
            'id_denuncia' => 2,
        ]);
        DB::table('denuncia_fotos')->insert([
            'url' => 'https://ex-software1.s3.amazonaws.com/detalle-shot-rota-con-una-lampara-de-la-calle-con-el-cielo-nublado-al-fondo-f5cnhd.jpg',
            'id_denuncia' => 3,
        ]);
    }
}
