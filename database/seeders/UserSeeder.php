<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Enrique',
            'status' => 'activo',
            'telefono' => '4431992866',
            'email' => 'enrique@hotmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'name' => 'Manriquez',
            'status' => 'activo',
            'telefono' => '4431888848',
            'email' => 'manriquez@gmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Administrador');

        User::create([
            'name' => 'ALFREDO Y GABY',
            'status' => 'activo',
            'telefono' => '4431387655',
            'email' => 'j.alfredo.flores@gmail.com',
            'password' => bcrypt('sistema'),
        ])->assignRole('Candidato');

    }
}
