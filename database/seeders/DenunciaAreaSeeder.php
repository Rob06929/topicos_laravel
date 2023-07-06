<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DenunciaAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'nombre' => 'Area1',
            'descripcion' => 'descripcion de Area',
        ]);
        DB::table('areas')->insert([
            'nombre' => 'Area2',
            'descripcion' => 'descripcion de Area',
        ]);
        DB::table('areas')->insert([
            'nombre' => 'Area3',
            'descripcion' => 'descripcion de Area',
        ]);
    }
}
