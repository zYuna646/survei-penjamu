<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Target;
use Illuminate\Support\Facades\DB;

class MasterTarget extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Target';

    public $target = [
        'nama' => '',
    ];

    public $dataTarget;

    public function mount()
    {
        // Dekode data JSON
        $this->dataTarget = Target::all();
    }

    public function render()
    {
        return view('livewire.admin.master.target.master-target', ['dataTarget' => $this->dataTarget])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Target');
    }

    public function addTarget()
    {
         // Validate the input
         $this->validate([
            'target.nama' => 'required|string|max:255',
        ]);


        try {
            DB::beginTransaction();

            Target::create([
                'name' => $this->target['nama'],
            ]);    

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil ditambahkan');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }
    
        return redirect()->to('master_target');
    }

    public function deleteTarget($id)
    {
        try {
            DB::beginTransaction();

            Target::findOrFail($id)->delete();

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil dihapus');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

       return redirect()->to('master_target');
    }
}
