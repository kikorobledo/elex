<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Capturista']);
        $role3 = Role::create(['name' => 'Telefonista']);
        $role4 = Role::create(['name' => 'Supervisor']);
        $role5 = Role::create(['name' => 'Candidato']);

        Permission::create(['name' => 'Lista de roles'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar rol'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de permisos'])->syncRoles([$role1]);
        Permission::create(['name' => 'Crear permiso'])->syncRoles([$role1]);
        Permission::create(['name' => 'Editar permiso'])->syncRoles([$role1]);
        Permission::create(['name' => 'Borrar permiso'])->syncRoles([$role1]);

        Permission::create(['name' => 'Lista de usuarios'])->syncRoles([$role1, $role4, $role5]);
        Permission::create(['name' => 'Crear usuario'])->syncRoles([$role1, $role4, $role5]);
        Permission::create(['name' => 'Editar usuario'])->syncRoles([$role1, $role4, $role5]);
        Permission::create(['name' => 'Borrar usuario'])->syncRoles([$role1, $role4, $role5]);

        Permission::create(['name' => 'Lista de referentes'])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create(['name' => 'Agregar referentes'])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create(['name' => 'Editar referentes'])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

        Permission::create(['name' => 'Lista de referidos'])->syncRoles([$role1, $role2, $role3, $role4, $role5]);
        Permission::create(['name' => 'Agregar referidos'])->syncRoles([$role1, $role2, $role3, $role4, $role5]);

    }
}
