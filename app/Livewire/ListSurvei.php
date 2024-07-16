<?php

namespace App\Livewire;
use App\Models\Jenis;
use App\Models\Target;
use App\Models\Survey;

use Livewire\Component;

class ListSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $jenis;
    public $target;
    public $surveis;

    public function mount()
    {
        $this->jenis = Jenis::all();
        $this->target = Target::all();
        $this->surveis = Survey::all();
    }

    public function render()
    {
        return view('livewire.landing.list-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - List '. $this->master);
    }
}
