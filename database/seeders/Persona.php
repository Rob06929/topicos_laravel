<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class Persona extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personas')->insert([
            'nombre' => 'Fernando Robledo',
            'telefono' => '78954612',
            'direccion' =>"Los Alamos 1820",
            'ci' =>"2165876",
        ]);
        DB::table('personas')->insert([
            'nombre' => 'Juan Carlos',
            'telefono' => '78954612',
            'direccion' =>"Los Alamos 1820",
            'ci' =>"2165876",
        ]);
        DB::table('personas')->insert([
            'nombre' => 'Maria Robledo',
            'telefono' => '78954612',
            'direccion' =>"Los Alamos 1820",
            'ci' =>"2165876",
        ]);
    }
}
