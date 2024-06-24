<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Fakultas;

class MasterFakultas extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Fakultas';

    public $fakultas = [
        'nama' => '',
        'kode' => '',
    ];

    public $dataFakultas;

    public function mount()
    {
        // Dekode data JSON
        $this->dataFakultas = Fakultas::all();
    }

    public function render()
    {
        return view('livewire.admin.master.fakultas.master-fakultas', ['dataFakultas' => $this->dataFakultas])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Fakultas');
    }

    public function addFakultas()
    {
        // Validate the input
        $this->validate([
            'fakultas.nama' => 'required|string|max:255',
            'fakultas.kode' => 'required|string|max:10|unique:fakultas,code',
        ]);

        Fakultas::create([
            'name' => $this->fakultas['nama'],
            'code' => $this->fakultas['kode'],
        ]);    
    
        return redirect()->to('master_fakultas');
    }

    public function deleteFakultas($id)
    {
        Fakultas::findOrFail($id)->delete();
       return redirect()->to('master_fakultas');
    }

}
