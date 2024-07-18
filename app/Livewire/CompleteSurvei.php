<?php

namespace App\Livewire;
use App\Models\Survey;

use Livewire\Component;

class CompleteSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $dataSurvei;

    public function mount($code)
    {
        $this->dataSurvei = Survey::where('code', $code)->first();
    }

    public function render()
    {
        return view('livewire.landing.complete-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Survei '.$this->dataSurvei['name']);
    }

   
}
