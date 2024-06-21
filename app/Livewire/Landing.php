<?php

namespace App\Livewire;

use Livewire\Component;

class Landing extends Component
{
    public $showNavbar = true;

    public function render()
    {
        return view('livewire.landing.landing')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar])
            ->title('UNG Survey - Landing');
    }
}