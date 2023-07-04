<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class Usuario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'fernando02',
            'email' => 'fernando02@gmail.com',
            'password' => bcrypt('laravel'),
            'estado_confirmacion' => 'false',
            'url_foto' => '1683672643776_foto2.jpg',
            'id_persona' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'carlos123',
            'email' => 'carlos@gmail.com',
            'password' => "admin123",
            'estado_confirmacion' => 'false',
            'url_foto' => '1683672643776_foto2.jpg',
            'id_persona' => '1',
        ]);
    }
}
