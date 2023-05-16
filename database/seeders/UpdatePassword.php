<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class UpdatePassword extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('update_passwords')->insert([
            'password'=>'asdfds',
            'fecha' => '2023/05/10',
            'id_usuario' => '1',
            'periodoUpdate'=> 30
        ]);
    }
}
