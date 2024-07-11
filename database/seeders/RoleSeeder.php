<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Universitas',
        ]);
        
        Role::create([
            'name' => 'Fakultas',
        ]);

        Role::create([
            'name' => 'Jurusan',
        ]);

        Role::create([
            'name' => 'prodi',
        ]);
    }
}
