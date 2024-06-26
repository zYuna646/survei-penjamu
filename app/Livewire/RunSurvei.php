<?php

namespace App\Livewire;

use Livewire\Component;

class RunSurvei extends Component
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

    public $nama;
    public $nim;
    public $prodi;
    public $responses = [];
    
    public function render()
    {
        return view('livewire.landing.run-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Survei '.$this->survey['name']);
    }

    public function sendSurveiRespon(){
        dd([
          'nama' => $this->nama,
          'nim' => $this->nim,
          'prodi' => $this->prodi,
          'responses' => $this->responses,
        ]);
    }

}
