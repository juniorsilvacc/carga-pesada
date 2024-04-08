<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'nome' => 'Admin',
            'email' => 'admin@admin.com.br',
            'cpf' => '12398712332',
            'rg' => '12345672',
            'data_nascimento' => '1996-09-04',
            'ativo' => true,
            'superuser' => true,
            'password' => '123456',
        ]);
    }
}
