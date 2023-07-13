<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Funcionario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('funcionarios')->insert([
            'codigo' => 'AD34AS',
            'id_area' => 1,
            'id_persona' => 2,
        ]);
        DB::table('funcionarios')->insert([
            'codigo' => 'AD34AS',
            'id_area' => 2,
            'id_persona' => 1,
        ]);

    }
}
