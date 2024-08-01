<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Jenis;
use Illuminate\Support\Facades\DB;

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
        return view('livewire.admin.master.jenis.master-jenis')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Jenis');
    }

    public function addJenis()
    {
        // Validate the input
        $this->validate([
            'jenis.nama' => 'required|string|max:255',
        ]);

        try{
            DB::beginTransaction();

            Jenis::create([
                'name' => $this->jenis['nama'],
            ]); 

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil ditambahkan');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->to('master_jenis');
    }

    public function deleteJenis($id)
    {
        try {
            DB::beginTransaction();

            Jenis::findOrFail($id)->delete();

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil dihapus');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }
       
        return redirect()->to('master_jenis');
    }
}
