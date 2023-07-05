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
            'url_foto'=>'https://imagenes.elpais.com/resizer/S-S1ykkQEs145yX5BB6voADSec8=/1200x0/cloudfront-eu-central-1.images.arcpublishing.com/prisa/IH2JTR2AYT73YY2IVNTF3BFV2Q.jpg',
            'id_persona' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'carlos123',
            'email' => 'carlos@gmail.com',
            'password' => bcrypt('admin123'),
            'estado_confirmacion' => 'false',
            'url_foto'=>'https://imagenes.elpais.com/resizer/S-S1ykkQEs145yX5BB6voADSec8=/1200x0/cloudfront-eu-central-1.images.arcpublishing.com/prisa/IH2JTR2AYT73YY2IVNTF3BFV2Q.jpg',
            'id_persona' => '2',
        ]);
    }
}
