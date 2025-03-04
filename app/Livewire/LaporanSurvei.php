<?php

namespace App\Livewire;

use App\Charts\SatisfactionChart;
use App\Models\Aspek;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LaporanSurvei extends Component
{
    public $survei;
    public $fakultas;
    public $prodi;
    public $totalRespondenProdi;
    public $selectedProdi;
    public $tahunAkademik;
    public $detail_rekapitulasi;
    public $detail_rekapitulasi_aspek;
    public $tanggalKegiatan;
    public $totalRespoondenProdi;

    public function mount($survei, $prodi, $tahunAkademik, $tanggalKegiatan)
    {
        $this->survei = Survey::find($survei);
        $this->fakultas = Fakultas::where('code', '!=', '0')->get();
        $this->prodi = Prodi::where('code', '!=', 0)->get();
        $this->selectedProdi = Prodi::find($prodi);
        $this->tahunAkademik = $tahunAkademik;
        $this->tanggalKegiatan = $tanggalKegiatan;
        $this->totalRespondenProdi = $this->countRespondenByProdi($prodi);
        $this->getDetailSurvey();
    }

    private function calculateFacultySatisfactionDistribution($aspekId)
    {

        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;
        $aspek = Aspek::find($aspekId);

        foreach ($aspek->indicator as $indicator) { 
            $query = DB::table($this->survei->id)
                ->where('prodi_id', $this->selectedProdi->id)
                ->where($indicator->id, '!=', null);

            // Sum up TM, CM, M, SM for this indicator
            $totalTM += $query->where($indicator->id, 1)->count();
            $totalCM += $query->where($indicator->id, 2)->count();
            $totalM += $query->where($indicator->id, 3)->count();
            $totalSM += $query->where($indicator->id, 4)->count();
        }

        return [
            'tm' => $totalTM,
            'cm' => $totalCM,
            'm' => $totalM,
            'sm' => $totalSM,
        ];
    }

    public function render(SatisfactionChart $satisfactionChart)
    {
        // Initialize data arrays
        $facultyNames = [];
        $facultyTM = [];
        $facultyCM = [];
        $facultyM = [];
        $facultySM = [];

        $prodiNames = [];
        $prodiTM = [];
        $prodiCM = [];
        $prodiM = [];
        $prodiSM = [];

        // Gather data for faculties
        foreach ($this->survei->aspek as $item) {
            $facultyNames[] = $item->name;
            $facultyData = $this->calculateFacultySatisfactionDistribution($item->id);

            $facultyTM[] = $facultyData['tm'];
            $facultyCM[] = $facultyData['cm'];
            $facultyM[] = $facultyData['m'];
            $facultySM[] = $facultyData['sm'];
        }

        // Build charts
        $facultyComparisonChart = $satisfactionChart->buildFacultyComparisonChart($facultyNames, $facultyTM, $facultyCM, $facultyM, $facultySM);

        return view('livewire.admin.report.laporan-survei', [
            'facultyComparisonChart' => $facultyComparisonChart,
        ]);
    }

    public function countRespondenByProdi($prodi_id)
    {
        return DB::table($this->survei->id)->where('prodi_id', $prodi_id)->count();
    }

    public function getDetailSurvey()
    {
        $detail_rekapitulasi = [];
        $detail_rekapitulasi_aspek = [];

        // Initialize the query
        $table = $this->survei->id; // Assuming the table name is based on survey id
        $query = DB::table($table);
        // Apply filters only if selections are made
        if ($this->selectedProdi) {
            // Filter by selected Prodi
            $query->where('prodi_id', $this->selectedProdi->id);
        } elseif ($this->selectedFakultas) {
            // Filter by selected Fakultas
            $prodiIds = Prodi::where('fakultas_id', $this->selectedFakultas)->pluck('id');
            $query->whereIn('prodi_id', $prodiIds);
        }

        // Loop through each Aspek in the survey
        foreach ($this->survei->aspek as $aspek) {
            $avg_tm = [];
            $avg_cm = [];
            $avg_m = [];
            $avg_sm = [];

            // Loop through each Indikator in the Aspek
            foreach ($aspek->indicator as $indicator) {
                // Clone the base query for each indicator
                $indicatorQuery = clone $query;

                // Initialize counts for TM, CM, M, SM
                $tm = $indicatorQuery->where($indicator->id, 1)->count();
                $cm = $indicatorQuery->where($indicator->id, 2)->count();
                $m = $indicatorQuery->where($indicator->id, 3)->count();
                $sm = $indicatorQuery->where($indicator->id, 4)->count();
                // Calculate averages and totals
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
                        'nilai_butir' => number_format($nilai_butir, 2),
                        'ikm' => $ikm,
                        'mutu_layanan' => $mutu_layanan,
                        'kinerja_unit' => $kinerja_unit,
                        'tingkat_kepuasan' => number_format($tingkat_kepuasan * 100, 2),
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

            // Calculate the average for the current Aspek
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
            'nilai_butir' => number_format($nilai_butir, 2),
            'ikm' => $ikm,
            'mutu_layanan' => $this->getMutuLayanan($nilai_butir),
            'kinerja_unit' => $this->getKinerjaUnit($ikm),
            'tingkat_kepuasan' => number_format($this->getTingkatKepuasan($tm, $cm, $m, $sm, $total) * 100, 2),
            'predikat_kepuasan' => $this->getPredikatKepuasan($this->getTingkatKepuasan($tm, $cm, $m, $sm, $total))
        ];
    }
}
