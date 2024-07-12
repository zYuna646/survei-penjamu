<?php

namespace App\Livewire;

use Livewire\Component;

class RecapSurvei extends Component
{
    public $showNavbar = false;
    public $showFooter = false;
    public $master = 'Survei';


    public function render()
    {
        return view('livewire.admin.report.recap-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Rekap Survei');
    }
}
