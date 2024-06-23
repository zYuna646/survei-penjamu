<?php

namespace App\Livewire;

use Livewire\Component;

class EditProdi extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Prodi';

    public $prodi = [];

    public function mount($id)
    {
        $dataJson = file_get_contents(resource_path('js/dummy.json'));
        $prodiData = json_decode($dataJson, true)['prodi'];

        $this->prodi = collect($prodiData)->where('id', $id)->first();
    }

    public function render()
    {
        return view('livewire.admin.master.prodi.edit-prodi')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Prodi');
    }

    public function redirectToAdd()
    {
        return redirect()->to('master_prodi');
    }
}
