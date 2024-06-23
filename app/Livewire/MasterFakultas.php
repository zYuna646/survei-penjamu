<?php

namespace App\Livewire;

use Livewire\Component;

class MasterFakultas extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Fakultas';

    public function mount()
    {
        // Data JSON
        $dataJson = file_get_contents(resource_path('js/dummy.json'));

        // Dekode data JSON
        $this->dataFakultas = json_decode($dataJson, true)['fakultas'];
    }

    public function render()
    {
        return view('livewire.admin.master.fakultas.master-fakultas', ['dataFakultas' => $this->dataFakultas])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Fakultas');
    }

   

}
