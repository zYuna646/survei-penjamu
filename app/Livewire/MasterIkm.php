<?php

namespace App\Livewire;

use Livewire\Component;

class MasterIkm extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'IKM';

    public $ikm = [
        // here is the CRUD field's
        'sample' => '',
    ];

    public $dataIkm;

    public function mount()
    {
        // here the data should be mount
        // $this->dataIkm = 
    }


    public function render()
    {
        return view('livewire.admin.master.ikm.master-ikm')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Master IKM');
    }

    public function addIkm()
    {

        // try {

        // } catch (\Exception $e) {
            
        // }


        // return redirect()->to('master_ikm');
    }

    public function deleteIkm() {}
}
