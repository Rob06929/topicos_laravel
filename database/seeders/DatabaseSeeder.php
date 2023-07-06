<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(Persona::class);
        $this->call(Usuario::class);
        $this->call(EmailConfirmation::class);
        $this->call(UpdatePassword::class);
        $this->call(VariableSeeder::class);
        $this->call(DenunciaEstadoSeeder::class);
        $this->call(DenunciaFotoSeeder::class);
        $this->call(DenunciaTipoSeeder::class);
        $this->call(DenunciaSeeder::class);
        $this->call(Funcionario::class);
        $this->call(DenunciaAreaSeeder::class);



        
    }
}
