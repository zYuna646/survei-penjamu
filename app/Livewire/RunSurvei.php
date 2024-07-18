<?php

namespace App\Livewire;
use App\Models\Survey;
use App\Models\Jurusan;
use App\Models\Aspek;
use App\Models\Indikator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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

    public $jurusan;
    public $data;


    public function mount($code)
    {
        $this->dataSurvei = Survey::where('code', $code)->first();
        $this->dataJurusan = Jurusan::all();
        $this->dataAspek = [];
        
        $aspekCollection = $this->dataSurvei->aspek;
        $data = [];
        foreach ($aspekCollection as $aspek) {
            // Mengumpulkan indikator yang memiliki id aspek yang sama
            $data[$aspek->id][0] = $aspek;
            $data[$aspek->id][1] = $aspek->indicator;
            $this->data =  $data;

        }

        $this->jumlahAspek = count($this->data);
    }
    public function render()
    {
        return view('livewire.landing.run-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Survei '.$this->dataSurvei['name']);
    }

    public function sendSurveiRespon(){
        $table = [];
        foreach ($this->responses as $index => $aspek) {
            foreach ($aspek as $key => $value) {
                $table[$key] = $value;
            }
        }
        $table['jurusan_id'] = $this->jurusan;
        DB::table($this->dataSurvei->id)->insert($table);

        return redirect()->route('complete_survei', ['code' => $this->dataSurvei->code]);
    }
}
