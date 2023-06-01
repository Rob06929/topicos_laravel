<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DenunciaEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('denuncia_estados')->insert([
            'nombre' => 'En espera',
            'descripcion' => 'descripcion de la denuncia',
        ]);
        DB::table('denuncia_estados')->insert([
            'nombre' => 'Cancelado',
            'descripcion' => 'descripcion de la denuncia',
        ]);
        DB::table('denuncia_estados')->insert([
            'nombre' => 'Realizada',
            'descripcion' => 'descripcion de la denuncia',
        ]);
    }
}
