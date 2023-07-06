<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenunciaTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('denuncia_tipos')->insert([
            'nombre' => 'Alcantarillado',
            'descripcion' => 'descripcion de la tipo',
            'id_area' => 1,

        ]);
        DB::table('denuncia_tipos')->insert([
            'nombre' => 'Iluminacion',
            'descripcion' => 'descripcion de la tipo',
            'id_area' => 2,

        ]);
        DB::table('denuncia_tipos')->insert([
            'nombre' => 'Parques y Jardines',
            'descripcion' => 'descripcion de tipo',
            'id_area' => 3,

        ]);
    }
}
