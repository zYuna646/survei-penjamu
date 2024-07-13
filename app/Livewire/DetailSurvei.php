<?php

namespace App\Livewire;

use App\Models\Survey;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use App\Charts\RecapChart;

class DetailSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';
    public $survey = [
        'name' => 'Survei kepuasan tenaga pendidik',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras lacinia eros blandit lectus rhoncus, . ',
        'target' => 'Universitas',
        'type' => 'Reguler',
        'aspek_total' => 3,
      ];

    public function render(RecapChart $chart)
    {
        $surveyId = 1;
        $survey = Survey::find($surveyId);
        $detail_rekapitulasi = [];
        $detail_rekapitulasi_aspek = [];
        foreach ($survey->aspek as $aspek) {
            $avg_tm = [];
            $avg_cm = [];
            $avg_m = [];
            $avg_sm = [];
            foreach ($aspek->indicator as $indicator) {
                $tm = Schema::findTable($survey->id)->where($indicator->id, 1)->count();
                $cm = Schema::findTable($survey->id)->where($indicator->id, 2)->count();
                $m = Schema::findTable($survey->id)->where($indicator->id, 3)->count();
                $sm = Schema::findTable($survey->id)->where($indicator->id, 4)->count();
                $avg_cm[] = $cm;
                $avg_m[] = $m;
                $avg_sm[] = $sm;
                $avg_tm[] = $tm;
                $total = $tm + $cm + $m + $sm;
                $nilai_butir = ($tm*1+2*$cm+3*$m+4*$sm)/($total);
                $ikm = $nilai_butir*25;
                $mutu_layanan = $nilai_butir > 3.26 ? 'A' : ($nilai_butir > 2.51 ? 'B' : ($nilai_butir > 1.76 ? 'C' : 'D'));
                $kinerja_unit = $ikm > 81.26 ? 'Sangat Baik' : ($ikm > 62.51 ? 'Baik' : ($ikm > 43.76 ? 'Kurang Baik' : 'Tidak Baik')); 
                $tingkat_kepuasan = (($tm/$total)+(($cm/$total)*2)+ (($m/$total)*3)+ (($sm/$total)*4) )/4;
                $predikat_kepuasan = $tingkat_kepuasan > 0.75 ? 'Sangat Puas' : 
                ($tingkat_kepuasan > 0.625 ? 'Puas' : 
                ($tingkat_kepuasan > 0.50 ? 'Cukup Puas' : 
                ($tingkat_kepuasan > 0.25 ? 'Kurang Puas' : 'Tidak Puas')));
                $detail_rekapitulasi[$aspek->id][$indicator->id] = [
                    1 => $tm,
                    2 => $cm,
                    3 => $m,
                    4 => $sm,
                    'total' => $total,
                    'nilai_butir' => $nilai_butir,
                    'ikm' => $ikm,
                    'mutu_layanan' => $mutu_layanan,
                    'kinerja_unit' => $kinerja_unit,
                    'tingkat_kepuasan' => $tingkat_kepuasan,
                    'predikat_kepuasan' => $predikat_kepuasan
                ];
            }
            $tm = round(array_sum($avg_tm) / count($avg_tm));
            $cm = round(array_sum($avg_cm) / count($avg_cm));
            $m = round(array_sum($avg_m) / count($avg_m));
            $sm = round(array_sum($avg_sm) / count($avg_sm));            
            $total = $tm + $cm + $m + $sm;
            $nilai_butir = ($tm*1+2*$cm+3*$m+4*$sm)/($total);
            $ikm = $nilai_butir*25;
            $mutu_layanan = $nilai_butir > 3.26 ? 'A' : ($nilai_butir > 2.51 ? 'B' : ($nilai_butir > 1.76 ? 'C' : 'D'));
            $kinerja_unit = $ikm > 81.26 ? 'Sangat Baik' : ($ikm > 62.51 ? 'Baik' : ($ikm > 43.76 ? 'Kurang Baik' : 'Tidak Baik'));
            $tingkat_kepuasan = (($tm/$total)+(($cm/$total)*2)+ (($m/$total)*3)+ (($sm/$total)*4) )/4;
            $predikat_kepuasan = $tingkat_kepuasan > 0.75 ? 'Sangat Puas' : 
            ($tingkat_kepuasan > 0.625 ? 'Puas' : 
            ($tingkat_kepuasan > 0.50 ? 'Cukup Puas' : 
            ($tingkat_kepuasan > 0.25 ? 'Kurang Puas' : 'Tidak Puas')));
            $detail_rekapitulasi_aspek[$aspek->id] = [
                'avg_tm' => $tm,
                'avg_cm' => $cm,
                'avg_m' => $m,
                'avg_sm' => $sm,
                'avg_total' => $total,
                'nilai_butir' => $nilai_butir,
                'ikm' => $ikm,
                'mutu_layanan' => $mutu_layanan,
                'kinerja_unit' => $kinerja_unit,
                'tingkat_kepuasan' => $tingkat_kepuasan,
                'predikat_kepuasan' => $predikat_kepuasan
            ];
        }
        
        

        return view('livewire.admin.master.survei.detail-survei', ['chart'  => $chart->build($this->survey['name'])])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Detil '. $this->survey['name']);
    }

}
