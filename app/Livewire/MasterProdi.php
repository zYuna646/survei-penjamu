<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Prodi;
use App\Models\Jurusan;
use App\Models\Fakultas;
use Illuminate\Support\Facades\DB;


class MasterProdi extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Prodi';

    public $prodi = [
        'nama' => '',
        'kode' => '',
        'fakultas_id' => '',
        'jurusan_id' => '',
    ];

    public $dataProdi;
    public $dataJurusan;

    public function mount()
    {
        $this->dataProdi = Prodi::all();
        $this->dataJurusan = Jurusan::all();
    }


    public function render()
    {
        return view('livewire.admin.master.prodi.master-prodi')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Prodi');
    }

    public function addProdi()
    {
        $this->validate([
            'prodi.nama' => 'required|string|max:255',
            'prodi.kode' => 'required|string|max:10|unique:prodis,code',
            'prodi.jurusan_id' => 'required|exists:jurusans,id',
        ]);
        
        try {
            DB::beginTransaction();
    
            Prodi::create([
                'name' => $this->prodi['nama'],
                'code' => $this->prodi['kode'],
                'jurusan_id' => $this->prodi['jurusan_id'],
            ]);

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil ditambahkan');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }
       

        return redirect()->to('master_prodi');
    }
    
    public function deleteProdi($id)    
    {
        try {
            DB::beginTransaction();

            Prodi::findOrFail($id)->delete();

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil dihapus');
            session()->flash('toastType', 'success');
            
        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }
        return redirect()->to('master_prodi');
    }
}
