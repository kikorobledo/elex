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
            'email' => 'enrique_j_@hotmail.com',
            'password' => bcrypt('12345678'),
        ])->assignRole('Administrador');

    }
}
