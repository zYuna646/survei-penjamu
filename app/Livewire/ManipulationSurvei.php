<?php

namespace App\Livewire;

use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManipulationSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $dataSurvei;
    public $data;
    public $jumlah;
    public $record;
    public $userRole;
    public $sisa = [];


    public function mount($id)
    {
        $user = Auth::user();
        $this->userRole = $user->role->slug;

        $this->dataSurvei = Survey::where('id', $id)->first();
        $aspekCollection = $this->dataSurvei->aspek;
        $data = [];
        $record = [];
        foreach ($aspekCollection as $aspek) {
            $data[$aspek->id][0] = $aspek;
            $data[$aspek->id][1] = $aspek->indicator;
            foreach ($aspek->indicator as $indicator) {
                $tmp = [
                    1 => DB::table($this->dataSurvei->id)->where($indicator->id, 1)->count(),
                    2 => DB::table($this->dataSurvei->id)->where($indicator->id, 2)->count(),
                    3 => DB::table($this->dataSurvei->id)->where($indicator->id, 3)->count(),
                    4 => DB::table($this->dataSurvei->id)->where($indicator->id, 4)->count(),
                ];
                $record[$indicator->id] = $tmp;
            }
        }
        $this->jumlah = DB::table($this->dataSurvei->id)->count();
        $this->record = $record;
        $this->data = $data;

        $this->calculateSisa();
    }

    public function updated($field)
    {
        $this->calculateSisa();
    }


    public function calculateSisa()
    {
        foreach ($this->record as $indicatorId => $values) {
            $tm = $values[1] ?? 0;
            $m = $values[2] ?? 0;
            $cm = $values[3] ?? 0;
            $sm = $values[4] ?? 0;

            // Debugging output
            \Log::info("Indicator ID: $indicatorId, TM: $tm, M: $m, CM: $cm, SM: $sm, Total: " . ($tm + $m + $cm + $sm));

            $this->sisa[$indicatorId] = $this->jumlah - ($tm + $m + $cm + $sm);
        }
    }



    public function render()
    {
        return view('livewire.admin.master.survei.manipulation-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Manipulasi Survei' . $this->dataSurvei['name']);
    }
}
