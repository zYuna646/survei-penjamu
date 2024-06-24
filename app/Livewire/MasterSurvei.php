<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Target;

class MasterSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $survei = [
        'nama' => '',
        'kode' => '',
    ];

    public $dataSurvei;
    public $dataTarget;

    public function mount()
    {
        // Dekode data JSON
        $dataJson = file_get_contents(resource_path('js/dummy.json'));
        $this->dataSurvei = json_decode($dataJson, true)['survei'];

        $this->dataTarget = Target::all();
    }

    public function render()
    {
        return view('livewire.admin.master.survei.master-survei', ['dataSurvei' => $this->dataSurvei, 'dataTarget' => $this->dataTarget])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Survei');
    }
}
