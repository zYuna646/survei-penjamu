<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Fakultas = Fakultas::create([
            'name' => 'Tidak Ada',
            'code' => '0',
        ]);

        $jurusan = Jurusan::create([
            'name' => 'Tidak Ada',
            'code' => '0',
            'fakultas_id' => $Fakultas->id,
        ]);

        $prodi = Prodi::create([
            'name' => 'Tidak Ada',
            'code' => '0',
            'fakultas_id' => $Fakultas->id,
        ]);
    }
}
