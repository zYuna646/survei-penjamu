<?php

namespace App\Livewire;

use Livewire\Component;

class MasterProdi extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Prodi';

    public function mount()
    {
        // Data JSON
        $dataJson = file_get_contents(resource_path('js/dummy.json'));

        // Dekode data JSON
        $this->dataProdi = json_decode($dataJson, true)['prodi'];
    }

    public function render()
    {
        return view('livewire.admin.master.prodi.master-prodi', ['dataProdi' => $this->dataProdi])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Prodi');
    }
}
