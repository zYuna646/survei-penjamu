<?php

namespace App\Livewire;

use App\Charts\SatisfactionChart;
use App\Models\Survey;
use App\Models\Aspek;
use App\Models\Indikator;
use App\Models\Temuan;
use App\Models\Fakultas;
use App\Models\Jurusan;
use App\Models\Prodi;
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

    public $dataFakultas;
    public $dataJurusan;
    public $dataProdi;

    public $selectedFakultas;
    public $selectedJurusan;
    public $selectedProdi;
    public $lowestIndicator;

    public function mount($id)
    {
        // Load all Fakultas, Jurusan, and Prodi data for filtering options
        $this->dataFakultas = Fakultas::all();
        $this->dataJurusan = Jurusan::all();
        $this->dataProdi = Prodi::all();
        $this->user = Auth::user();

        // Load the survey data
        $this->survei = Survey::findOrFail($id);
        switch ($this->user->role->slug) {
            case 'fakultas':
                # code...
                $this->selectedFakultas = $this->user->fakultas_id;
                $this->getProdiByFakultas();
                break;
            case 'prodi':
                $this->selectedProdi = $this->user->prodi_id;
                break;
            default:
                # code...
                break;
        }
        $this->getDetailSurvey();
        $this->getLowest();

        // Initialize rekapitulasi arrays

    }

    public function getDetailSurvey()
    {
        $detail_rekapitulasi = [];
        $detail_rekapitulasi_aspek = [];

        // Initialize the query
        $table = $this->survei->id; // Assuming the table name is based on survey ID
        $query = DB::table($table)->get();

        // Apply filters based on selections
        if ($this->selectedProdi) {
            $query->where('prodi_id', $this->selectedProdi);
        } elseif ($this->selectedFakultas) {
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
                // Initialize counts for TM, CM, M, SM
                $tm = $query->where($indicator->id, 1)->count();
                $cm = $query->where($indicator->id, 2)->count();
                $m = $query->where($indicator->id, 3)->count();
                $sm = $query->where($indicator->id, 4)->count();
                // Store the counts for averaging
                $avg_tm[] = $tm;
                $avg_cm[] = $cm;
                $avg_m[] = $m;
                $avg_sm[] = $sm;

                // Calculate totals and avoid division by zero
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
                    // Handle case where no responses are available
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

        // Store results for later use
        $this->detail_rekapitulasi = $detail_rekapitulasi;
        $this->detail_rekapitulasi_aspek = $detail_rekapitulasi_aspek;
    }


    private function getLowest()
    {
        // Initialize an array to hold all indicators with their 'nilai_butir' values
        $allIndicators = [];

        // Iterate through aspects and indicators
        foreach ($this->survei->aspek as $aspek) {
            foreach ($aspek->indicator as $indicator) {
                // Ensure 'nilai_butir' is set and valid
                $nilaiButir = $this->detail_rekapitulasi[$aspek->id][$indicator->id]['nilai_butir'] ?? null;

                if ($nilaiButir !== null) {
                    // Add indicator details to the array
                    $allIndicators[] = [
                        'name' => $indicator->name,
                        'nilai_butir' => $nilaiButir,
                        'aspek_id' => $aspek->id,
                        'aspek_name' => $aspek->name,
                        'indicator_id' => $indicator->id,
                        'detail_rekapitulasi' => $this->detail_rekapitulasi[$aspek->id][$indicator->id]
                    ];
                }
            }
        }

        // Sort the indicators by 'nilai_butir' in ascending order
        usort($allIndicators, function ($a, $b) {
            return $a['nilai_butir'] <=> $b['nilai_butir'];
        });

        // Limit to the 5 lowest values
        $lowestIndicators = array_slice($allIndicators, 0, 5);

        // Return the results
        $this->lowestIndicator = $lowestIndicators;
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

    public function getProdiByFakultas()
    {
        if ($this->selectedFakultas) {
            $this->dataProdi = Prodi::where('fakultas_id', $this->selectedFakultas)->get();
            $this->getDetailSurvey();
        } else {
            $this->dataProdi = [];
            $this->selectedProdi = null;
            $this->getDetailSurvey();
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
        foreach ($this->dataFakultas as $fakultas) {
            $facultyNames[] = $fakultas->name;
            $facultyData = $this->calculateFacultySatisfactionDistribution($fakultas->id);

            $facultyTM[] = $facultyData['tm'];
            $facultyCM[] = $facultyData['cm'];
            $facultyM[] = $facultyData['m'];
            $facultySM[] = $facultyData['sm'];
        }

        // Gather data for Prodis
        foreach ($this->dataProdi as $prodi) {
            $prodiNames[] = $prodi->name;
            $prodiData = $this->calculateProdiSatisfactionDistribution($prodi->id);

            $prodiTM[] = $prodiData['tm'];
            $prodiCM[] = $prodiData['cm'];
            $prodiM[] = $prodiData['m'];
            $prodiSM[] = $prodiData['sm'];
        }

        // Build charts
        $facultyComparisonChart = $satisfactionChart->buildFacultyComparisonChart($facultyNames, $facultyTM, $facultyCM, $facultyM, $facultySM);
        $prodiComparisonChart = $satisfactionChart->buildProdiComparisonChart($prodiNames, $prodiTM, $prodiCM, $prodiM, $prodiSM);

        return view('livewire.admin.master.survei.detail-survei', [
            'facultyComparisonChart' => $facultyComparisonChart,
            'prodiComparisonChart' => $prodiComparisonChart,
        ])
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Detil ' . $this->survei['name']);
    }

    private function calculateFacultySatisfactionDistribution($facultyId)
    {
        $fakultasIds = Fakultas::where('id', $facultyId)->pluck('id');
        $prodiIds = Prodi::whereIn('fakultas_id', $fakultasIds)->pluck('id');

        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;

        // Loop through each aspect of the survey
        foreach ($this->survei->aspek as $aspek) {
            // Loop through each indicator within the aspect
            foreach ($aspek->indicator as $indicator) {
                $query = DB::table($this->survei->id)
                    ->whereIn('prodi_id', $prodiIds)
                    ->where($indicator->id, '!=', null)->get( );

                // Sum up TM, CM, M, SM for this indicator
                $totalTM += $query->where($indicator->id, 1)->count();
                $totalCM += $query->where($indicator->id, 2)->count();
                $totalM += $query->where($indicator->id, 3)->count();
                $totalSM += $query->where($indicator->id, 4)->count();
            }
        }

        return [
            'tm' => $totalTM,
            'cm' => $totalCM,
            'm' => $totalM,
            'sm' => $totalSM,
        ];
    }


    private function calculateProdiSatisfactionDistribution($prodiId)
    {
        // Initialize totals
        $totalTM = 0;
        $totalCM = 0;
        $totalM = 0;
        $totalSM = 0;

        // Loop through each aspect of the survey
        foreach ($this->survei->aspek as $aspek) {
            // Loop through each indicator within the aspect
            foreach ($aspek->indicator as $indicator) {
                $query = DB::table($this->survei->id)
                    ->where('prodi_id', $prodiId)
                    ->where($indicator->id, '!=', null)->get();

                // Sum up TM, CM, M, SM for this indicator
                $totalTM += $query->where($indicator->id, 1)->count();
                $totalCM += $query->where($indicator->id, 2)->count();
                $totalM += $query->where($indicator->id, 3)->count();
                $totalSM += $query->where($indicator->id, 4)->count();
            }
        }

        return [
            'tm' => $totalTM,
            'cm' => $totalCM,
            'm' => $totalM,
            'sm' => $totalSM,
        ];
    }


    // private function calculateSatisfactionDistribution($query)
    // {
    //     return [
    //         'tm' => $query->where('response', 1)->count(),
    //         'cm' => $query->where('response', 2)->count(),
    //         'm' => $query->where('response', 3)->count(),
    //         'sm' => $query->where('response', 4)->count(),
    //     ];
    // }

}
