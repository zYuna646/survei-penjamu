<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Jurusan;
use App\Models\Fakultas;

class MasterJurusan extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Jurusan';

    public $jurusan = [
        'nama' => '',
        'kode' => '',
        'fakultas_id' => '',
    ];

    public $dataJurusan;
    public $dataFakultas;

    public function mount()
    {
        // Dekode data JSON
        $this->dataJurusan = Jurusan::all();
        $this->dataFakultas = Fakultas::all();
    }

    public function render()
    {
        return view('livewire.admin.master.jurusan.master-jurusan', ['dataJurusan' => $this->dataJurusan, 'dataFakultas' => $this->dataFakultas])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Jurusan');
    }

    public function addJurusan()
    {
        // Validate the input
        $this->validate([
            'jurusan.nama' => 'required|string|max:255',
            'jurusan.kode' => 'required|string|max:10|unique:jurusans,code',
            'jurusan.fakultas_id' => 'required|exists:fakultas,id',
        ]);

        Jurusan::create([
            'name' => $this->jurusan['nama'],
            'code' => $this->jurusan['kode'],
            'fakultas_id' => $this->jurusan['fakultas_id'],
        ]);    
    
        return redirect()->to('master_jurusan');
    }

    public function deleteJurusan($id)
    {
        Jurusan::findOrFail($id)->delete();
        return redirect()->to('master_jurusan');
    }

}
