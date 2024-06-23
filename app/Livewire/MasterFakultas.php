<?php

namespace App\Livewire;

use Livewire\Component;

class MasterFakultas extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Fakultas';

    public function render()
    {
        return view('livewire.admin.master.fakultas.master-fakultas')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar], ['showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Fakultas');
    }

}
