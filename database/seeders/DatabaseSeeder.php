<?php

namespace Database\Seeders;

use App\Models\SolidarityEvents;
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
        \App\Models\SolidarityEvents::create([
            'name' => 'Usuário de teste',
            'email' => 'tamyressilvazz@outlook.com',
            'password' => bcrypt( '12345' ),
            'job_title' => 'Gerente administrativo'
        ]);
    }
}
