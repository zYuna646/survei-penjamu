<?php

namespace App\Livewire;
use App\Models\Survey;
use App\Models\Jurusan;
use App\Models\Aspek;
use App\Models\Indikator;

use Livewire\Component;

class RunSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $responses = [];

    public $dataJurusan;
    public $dataSurvei;
    public $dataAspek;
    public $jurusan_id;

    public function mount($code)
    {
        $this->dataSurvei = Survey::where('code', $code)->first();
        $this->dataJurusan = Jurusan::all();
        $this->dataAspek = [];
        
        $aspekCollection = $this->dataSurvei->aspek;

        foreach ($aspekCollection as $aspek) {
            // Mengumpulkan indikator yang memiliki id aspek yang sama
            $indikatorCollection = $aspek->indicator;
            $indikatorArray = $indikatorCollection->pluck('name')->toArray();
    
            $this->dataAspek[] = [
                'id' => $aspek->id,
                'name' => $aspek->name,
                'indicators' => $indikatorArray
            ];
        }

        $this->jumlahAspek = count($this->dataAspek);
    }
    public function render()
    {
        return view('livewire.landing.run-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Survei '.$this->dataSurvei['name']);
    }

    public function sendSurveiRespon(){
        dd([
          'jurusan_id' => $this->jurusan_id,
          'responses' => $this->responses,
        ]);
    }
}
