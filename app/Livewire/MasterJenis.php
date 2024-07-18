<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Jenis;

class MasterJenis extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Jenis';

    public $jenis = [
        'nama' => '',
    ];

    public $dataJenis;

    public function mount()
    {
        // Dekode data JSON
        $this->dataJenis = Jenis::all();
    }

    public function render()
    {
        return view('livewire.admin.master.jenis.master-jenis', ['dataJenis' => $this->dataJenis])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Jenis');
    }

    public function addJenis()
    {
        // Validate the input
        $this->validate([
            'jenis.nama' => 'required|string|max:255',
        ]);

        Jenis::create([
            'name' => $this->jenis['nama'],
        ]);    
    
        return redirect()->to('master_jenis');
    }

    public function deleteJenis($id)
    {
        Jenis::findOrFail($id)->delete();
        return redirect()->to('master_jenis');
    }
}
