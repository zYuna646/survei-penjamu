<?php

namespace Database\Seeders;

use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FakultasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tb_f = DB::table('tb_fakultas')->get();
        $tb_p = DB::table('tb_prodi')->get();
        $tb_je = DB::table('tb_jenjang')->get();

        // Create the 'Tidak Ada' Fakultas and Prodi
        $fakultasTidakAda = Fakultas::create([
            'name' => 'Tidak Ada',
            'code' => '0',
        ]);

        $prodiTidakAda = Prodi::create([
            'name' => 'Tidak Ada',
            'code' => '0',
            'fakultas_id' => $fakultasTidakAda->id,
        ]);

        // Retrieve roles
        $prodiRole = Role::where('slug', 'prodi')->first();
        $fakultasRole = Role::where('slug', 'fakultas')->first();

        // Loop through the Fakultas and Prodi tables to seed the data
        foreach ($tb_f as $f) {
            $fakultas = Fakultas::create([
                'name' => $f->fakultas_nama,
                'code' => $f->fakultas_alias,
            ]);

            // Create a user with Fakultas role
            User::create([
                'name' => $f->fakultas_nama,
                'email' => strtolower($f->fakultas_alias) . '@gmail.com',
                'password' => bcrypt($f->fakultas_nama), // Use a default password or something more secure
                'role_id' => $fakultasRole->id,
                'fakultas_id' => $fakultas->id,
                'prodi_id' => $prodiTidakAda->id, // No Prodi ID for Fakultas users
            ]);

            foreach ($tb_p->where('prodi_fakultas', $f->fakultas_id) as $p) {
                $jenjang = $tb_je->where('jenjang_id', $p->prodi_jenjang)->first();
                $prodi = Prodi::create([
                    'name' => $jenjang->jenjang_nama .'-'.$p->prodi_nama,
                    'code' => Str::slug($jenjang->jenjang_nama .'-'.$p->prodi_nama),
                    'fakultas_id' => $fakultas->id,
                ]);

                // Create a user with Prodi role
                User::create([
                    'name' => $jenjang->jenjang_nama .'-'.$p->prodi_nama,
                    'email' => strtolower($jenjang->jenjang_nama .'-'.$p->prodi_nama) . '@gmail.com',
                    'password' => bcrypt($jenjang->jenjang_nama .'-'.$p->prodi_nama), // Use a default password or something more secure
                    'role_id' => $prodiRole->id,
                    'fakultas_id' => $fakultasTidakAda->id,
                    'prodi_id' => $prodi->id,
                ]);
            }
        }
    }

    /**
     * Generate a slug from a string.
     */
    private function slug($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
}
