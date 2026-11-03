<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::firstOrCreate([
            'name' => 'kelola pengguna',
            'guard_name' => 'web',
        ]);

        Permission::firstOrCreate([
            'name' => 'lihat progres',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $dosen = Role::firstOrCreate([
            'name' => 'dosen',
            'guard_name' => 'web',
        ]);

        Role::firstOrCreate([
            'name' => 'mahasiswa',
            'guard_name' => 'web',
        ]);

        $admin->syncPermissions([
            'kelola pengguna',
            'lihat progres',
        ]);

        $dosen->syncPermissions([
            'lihat progres',
        ]);
    }
}
