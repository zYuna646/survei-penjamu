<?php

namespace App\Livewire;

use App\Models\Survey;
use App\Models\Aspek;
use App\Models\Indikator;
use App\Models\Temuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Charts\RecapChart;

class DetailSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';
    public $survei;
    public $user;
    public $temuan = [];

    public $detail_rekapitulasi;
    public $detail_rekapitulasi_aspek;
    public $selected_indikator;
    public $data_temuan = [];
    public $curent_user_value = [];
    

    public function mount($id)
    {
        $this->user = Auth::user();

        $this->survei = Survey::FindOrFail($id);
        $detail_rekapitulasi = [];
        $detail_rekapitulasi_aspek = [];

        foreach ($this->survei->aspek as $aspek) {
            $avg_tm = [];
            $avg_cm = [];
            $avg_m = [];
            $avg_sm = [];

            foreach ($aspek->indicator as $indicator) {
                $table = $this->survei->id; // Assuming the table is named like this
                $fakultas = 0;
                $jurusan = 0;
                $prodi = 0;
                
                // $jurusan_id = 1; // contoh ID jurusan

                $tm = DB::table($table)
                        ->where($indicator->id, 1)
                      
                        ->count();

                $cm = DB::table($table)
                        ->where($indicator->id, 2)
                        ->count();

                $m = DB::table($table)
                        ->where($indicator->id, 3)
                        ->count();

                $sm = DB::table($table)
                        ->where($indicator->id, 4)
                        ->count();

                $avg_tm[] = $tm;
                $avg_cm[] = $cm;
                $avg_m[] = $m;
                $avg_sm[] = $sm;

                $total = $tm + $cm + $m + $sm;
                if ($total > 0) {
                    $nilai_butir = ($tm * 1 + 2 * $cm + 3 * $m + 4 * $sm) / $total;
                    $ikm = $nilai_butir * 25;

                    $mutu_layanan = $this->getMutuLayanan($nilai_butir);
                    $kinerja_unit = $this->getKinerjaUnit($ikm);
                    $tingkat_kepuasan = $this->getTingkatKepuasan($tm, $cm, $m, $sm, $total);
                    $predikat_kepuasan = $this->getPredikatKepuasan($tingkat_kepuasan);

                    $detail_rekapitulasi[$aspek->id][$indicator->id] = [
                        1 => $tm,
                        2 => $cm,
                        3 => $m,
                        4 => $sm,
                        'total' => $total,
                        'nilai_butir' => number_format($nilai_butir,2),
                        'ikm' => $ikm,
                        'mutu_layanan' => $mutu_layanan,
                        'kinerja_unit' => $kinerja_unit,
                        'tingkat_kepuasan' => number_format( $tingkat_kepuasan * 100, 2),
                        'predikat_kepuasan' => $predikat_kepuasan
                    ];
                } else {
                    $detail_rekapitulasi[$aspek->id][$indicator->id] = [
                        1 => $tm,
                        2 => $cm,
                        3 => $m,
                        4 => $sm,
                        'total' => 0,
                        'nilai_butir' => 0,
                        'ikm' => 0,
                        'mutu_layanan' => 'N/A',
                        'kinerja_unit' => 'N/A',
                        'tingkat_kepuasan' => 0,
                        'predikat_kepuasan' => 'N/A'
                    ];
                }
            }

            $detail_rekapitulasi_aspek[$aspek->id] = $this->calculateAverageRekapitulasi($avg_tm, $avg_cm, $avg_m, $avg_sm);
        }
        $this->detail_rekapitulasi = $detail_rekapitulasi;
        $this->detail_rekapitulasi_aspek = $detail_rekapitulasi_aspek;
    }

    private function getMutuLayanan($nilai_butir)
    {
        if ($nilai_butir > 3.26) {
            return 'A';
        } elseif ($nilai_butir > 2.51) {
            return 'B';
        } elseif ($nilai_butir > 1.76) {
            return 'C';
        } else {
            return 'D';
        }
    }

    private function getKinerjaUnit($ikm)
    {
        if ($ikm > 81.26) {
            return 'Sangat Baik';
        } elseif ($ikm > 62.51) {
            return 'Baik';
        } elseif ($ikm > 43.76) {
            return 'Kurang Baik';
        } else {
            return 'Tidak Baik';
        }
    }

    private function getTingkatKepuasan($tm, $cm, $m, $sm, $total)
    {
        if ($total == 0) {
            return 0; // Default value or handle as needed
        }
        return (($tm / $total) + (($cm / $total) * 2) + (($m / $total) * 3) + (($sm / $total) * 4)) / 4;
    }

    private function getPredikatKepuasan($tingkat_kepuasan)
    {
        if ($tingkat_kepuasan > 0.75) {
            return 'Sangat Puas';
        } elseif ($tingkat_kepuasan > 0.625) {
            return 'Puas';
        } elseif ($tingkat_kepuasan > 0.50) {
            return 'Cukup Puas';
        } elseif ($tingkat_kepuasan > 0.25) {
            return 'Kurang Puas';
        } else {
            return 'Tidak Puas';
        }
    }

    public function getTemuan($indikator_id)
    {
        $this->selected_indikator = Indikator::find($indikator_id);

        // Inisialisasi query dasar
        $query = Temuan::where('indikator_id', $indikator_id);

        switch ($this->user->role->slug) {
            case 'universitas':
                // Tampilkan semua data temuan
                $this->temuan['temuan']= $query->where('fakultas_id', null)->where('prodi_id', null)->first()->temuan ?? '';
                $query = Temuan::where('indikator_id', $indikator_id);
                break;
            case 'fakultas':
                // Ambil ID fakultas pengguna
                $fakultas_id = $this->user->fakultas->id;
                
                // Ambil ID prodi yang terkait dengan fakultas
                 $prodi_ids = DB::table('prodis')
                ->join('jurusans', 'prodis.jurusan_id', '=', 'jurusans.id')
                ->where('jurusans.fakultas_id', $fakultas_id)
                ->pluck('prodis.id');
                
                // Filter data temuan berdasarkan fakultas dan prodi dalam fakultas
                $query->where(function ($q) use ($fakultas_id, $prodi_ids) {
                    $q->where('fakultas_id', $fakultas_id)
                    ->orWhereIn('prodi_id', $prodi_ids);
                });

                $this->temuan['temuan']= $query->where('fakultas_id', $fakultas_id)->first()->temuan ?? '';

                break;
            case 'prodi':
                // Filter data temuan berdasarkan prodi pengguna
                $prodi_id = $this->user->prodi->id;
                $query->where('prodi_id', $prodi_id);
                break;
            default:
                // Tangani peran yang tidak terduga jika perlu
                break;
        }

        
        // Ambil data temuan yang sudah difilter
        $this->data_temuan = $query->get();
    }
    public function saveTemuan()
    {
        
        $this->validate([
            'temuan.temuan' => 'required'
        ]);

        $fakultas_id = null;
        $prodi_id = null;

        switch ($this->user->role->slug) {
            case 'universitas':
                // Both fakultas_id and prodi_id should be null
                break;
            case 'fakultas':
                // Set fakultas_id as needed, prodi_id should be null
                $fakultas_id = $this->user->fakultas->id; // Make sure $this->fakultas_id is set
                break;
            case 'prodi':
                // Set prodi_id as needed, fakultas_id should be null
                $prodi_id = $this->user->prodi->id; // Make sure $this->prodi_id is set
                break;
            default:
                // Handle unexpected user roles if needed
                break;
        }

        $existingTemuan = Temuan::where('indikator_id', $this->selected_indikator->id)
        ->where('fakultas_id', $fakultas_id)
        ->where('prodi_id', $prodi_id)
        ->first();

        if ($existingTemuan) {
            // Jika sudah ada, lakukan update
            $existingTemuan->update([
                'temuan' => $this->temuan['temuan'],
            ]);
        } else {
            // Jika belum ada, lakukan insert
            Temuan::create([
                'temuan' => $this->temuan['temuan'],
                'indikator_id' => $this->selected_indikator->id,
                'fakultas_id' => $fakultas_id,
                'prodi_id' => $prodi_id,
            ]);
        }

        return redirect()->route('detail_survei', ['id' => $this->survei->id]);
    }

    private function calculateAverageRekapitulasi($avg_tm, $avg_cm, $avg_m, $avg_sm)
    {
        $tm = round(array_sum($avg_tm) / count($avg_tm));
        $cm = round(array_sum($avg_cm) / count($avg_cm));
        $m = round(array_sum($avg_m) / count($avg_m));
        $sm = round(array_sum($avg_sm) / count($avg_sm));
        $total = $tm + $cm + $m + $sm;

        if ($total > 0) {
            $nilai_butir = ($tm * 1 + 2 * $cm + 3 * $m + 4 * $sm) / $total;
            $ikm = $nilai_butir * 25;
        } else {
            $nilai_butir = 0;
            $ikm = 0;
        }

        return [
            1 => $tm,
            2 => $cm,
            3 => $m,
            4 => $sm,
            'total' => $total,
            'nilai_butir' => number_format($nilai_butir,2),
            'ikm' => $ikm,
            'mutu_layanan' => $this->getMutuLayanan($nilai_butir),
            'kinerja_unit' => $this->getKinerjaUnit($ikm),
            'tingkat_kepuasan' => number_format( $this->getTingkatKepuasan($tm, $cm, $m, $sm, $total) * 100,2),
            'predikat_kepuasan' => $this->getPredikatKepuasan($this->getTingkatKepuasan($tm, $cm, $m, $sm, $total))
        ];
    }

    public function render(RecapChart $chart)
    {
        return view('livewire.admin.master.survei.detail-survei', ['chart' => $chart->build($this->survei['name'])])
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Detil ' . $this->survei['name']);
    }
}
