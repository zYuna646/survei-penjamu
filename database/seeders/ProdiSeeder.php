<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fakultas = Fakultas::where('code', '!=', '0')->get(); // Fix 1: Fetch records

        foreach ($fakultas as $item) {
            $prodiTidakAda = Prodi::where('fakultas_id', $item->id)
                ->where('name', 'Tidak Ada')
                ->exists(); // Fix 2 & 3: Check existence properly

            if (!$prodiTidakAda) {
                Prodi::create([
                    'name' => 'Tidak Ada',
                    'code' => '0',
                    'fakultas_id' => $item->id
                ]);
            }
        }
    }

}
