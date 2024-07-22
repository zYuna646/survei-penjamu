<?php

namespace App\Livewire;

use App\Models\Survey;
use App\Models\Jurusan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RunSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $isComplete = false;
    public $showForm;
    public $master = 'Survei';

    public $responses = [];

    public $dataJurusan;
    public $dataSurvei;
    public $jurusan_id;

    public $jurusan;
    public $data;

    public function mount($code)
    {
        $this->dataSurvei = Survey::where('code', $code)->first();
        $this->dataJurusan = Jurusan::all();
        
        
        $aspekCollection = $this->dataSurvei->aspek;
        $data = [];
        foreach ($aspekCollection as $aspek) {
            $data[$aspek->id][0] = $aspek;
            $data[$aspek->id][1] = $aspek->indicator;
        }
        $this->data = $data;

        $this->showForm = !empty($this->data) && $this->dataSurvei->isAktif;
    }

    public function render()
    {
        if ($this->isComplete) {
            return view('livewire.landing.complete-survei', ['dataSurvei' => $this->dataSurvei])
                ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
                ->title('UNG Survey - Result');
        }

        return view('livewire.landing.run-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Survei ' . $this->dataSurvei['name']);
    }

    public function sendSurveiRespon()
    {
        $table = [];
        foreach ($this->responses as $index => $aspek) {
            foreach ($aspek as $key => $value) {
                $table[$key] = $value;
            }
        }
        $table['jurusan_id'] = $this->jurusan;
        DB::table($this->dataSurvei->id)->insert($table);
        
        $this->isComplete = true;
    }

}
