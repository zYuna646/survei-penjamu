<?php

namespace App\Livewire;

use Livewire\Component;

class MasterFakultas extends Component
{
    public $showNavbar = true;
    public $master = 'Fakultas';
    public $showModal = false;

    protected $listeners = [
        'openModal' => 'openModal',
        'triggerFunction' => 'triggerFunction'
    ];

    public function render()
    {
        return view('livewire.admin.master.fakultas.master-fakultas')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar])
        ->title('UNG Survey - Master Fakultas');
    }

    public function handleAdd(){
        
    }
}
