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
    public function mount($id){
        $survei = Survey::findOrFail($id);
        $this->survei = $survei;
        $this->fakultas = Fakultas::where('code', '!=', '0')->get();
        $this->prodi = Prodi::where('code', '!=', '0')->get();

        foreach ($this->prodi as $p) {
            $this->totalRespondenProdi[$p->id] = $this->countRespondenByProdi($p->id);
        }
    }

    public function render()
    {
        return view('livewire.admin.report.laporan-survei');
    }

    public function countRespondenByProdi($prodi_id){
        return DB::table($this->survei->id)->where('prodi_id', $prodi_id)->count();
    }
}
