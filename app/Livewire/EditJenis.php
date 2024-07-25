<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Jenis;
use Illuminate\Support\Facades\DB;

class EditJenis extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Jenis';

    public $jenis = [];

    public function mount($id)
    {
        // Fetch fakultas data by ID from the model
        $jenis = Jenis::findOrFail($id);
        // Assign all data to the fakultas property
        $this->jenis = $jenis->toArray();
    }

    public function render()
    {
        return view('livewire.admin.master.jenis.edit-jenis')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Jenis');
    }

    public function updateJenis(){

        $this->validate([
            'jenis.name' => 'required|string|max:255',
        ]);

        $jenis = Jenis::findOrFail($this->jenis['id']);

        try {
            DB::beginTransaction();

            $jenis->update($this->jenis);

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil diedit');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->to('master_jenis');
    }

    public function redirectToAdd()
    {
        return redirect()->to('master_jenis');
    }
}
