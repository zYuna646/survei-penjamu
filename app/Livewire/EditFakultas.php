<?php

namespace App\Livewire;

use Livewire\Component;

class EditFakultas extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Fakultas';

    public $fakultas = [];

    public function mount($id)
    {
        // Replace this with your logic to fetch fakultas data by ID
        $dataJson = file_get_contents(resource_path('js/dummy.json'));
        $fakultasData = json_decode($dataJson, true)['fakultas'];

        // Find the fakultas by ID (assuming fakultas has 'id' field)
        $this->fakultas = collect($fakultasData)->where('id', $id)->first();
    }

    public function render()
    {
        return view('livewire.admin.master.fakultas.edit-fakultas')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Fakultas');
    }

    public function redirectToAdd()
    {
        return redirect()->to('master_fakultas');
    }

}
