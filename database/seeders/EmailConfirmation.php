<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class EmailConfirmation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('email_confirmations')->insert([
            'uid' => 549862167,
            'fecha_hora' => Carbon::now(),
            'id_usuario' => '1',
        ]);
    }
}
