<?php

namespace App\Livewire;

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
    public $detail;
    public $detailAspek;


    public function mount($survei = null, $fakultas = null, $prodi = null, $selectedProdi = null, $totalRespoondenProdi = null, $tahunAkademik = null, $detail = null, $detailAspek = null)
    {
        $this->survei = $survei ? collect($survei) : null;
        $this->fakultas = $fakultas ? collect($fakultas) : Fakultas::where('code', '!=', '0')->get();
        $this->prodi = $prodi ? collect($prodi) : Prodi::where('code', '!=', '0')->get();
        $this->selectedProdi = $selectedProdi;
        $this->totalRespondenProdi = $totalRespoondenProdi;
        $this->tahunAkademik = $tahunAkademik;
        $this->detail = $detail;
        $this->detailAspek = $detailAspek;

    }

    public function render()
    {
        return view('livewire.admin.report.laporan-survei');
    }

    public function countRespondenByProdi($prodi_id)
    {
        return DB::table($this->survei->id)->where('prodi_id', $prodi_id)->count();
    }
}
