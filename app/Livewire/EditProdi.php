<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Prodi;
use App\Models\Jurusan;

class EditProdi extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Prodi';

    public $prodi = [];
    public $dataJurusan;

    public function mount($id)
    {
        $this->dataJurusan = Jurusan::all();
        $prodi = Prodi::findOrFail($id);

        // Assign all data to the jurusan property
        $this->prodi = $prodi->toArray();
    }

    public function render()
    {
        return view('livewire.admin.master.prodi.edit-prodi')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Prodi');
    }

    public function updateProdi()
    {
        $this->validate([
            'prodi.name' => 'required|string|max:255',
            'prodi.code' => 'required|string|max:10|unique:prodis,code,' . $this->prodi['id'],
            'prodi.jurusan_id' => 'required|exists:jurusans,id',
        ]);

        $prodi = Prodi::findOrFail($this->prodi['id']);
        $prodi->update($this->prodi);

        return redirect()->to('master_prodi');
    }

    public function redirectToAdd()
    {
        return redirect()->to('master_prodi');
    }
}
