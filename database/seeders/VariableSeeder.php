<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class VariableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('variables')->insert([
            'periodo_password' => 30,
            'periodo_confirmacion' => 30,
        ]);
    }
}
