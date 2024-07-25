<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Target;
use Illuminate\Support\Facades\DB;

class EditTarget extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Target';

    public $target = [];

    public function mount($id)
    {
        // Fetch fakultas data by ID from the model
        $target = Target::findOrFail($id);

        // Assign all data to the fakultas property
        $this->target = $target->toArray();
    }

    public function render()
    {
        return view('livewire.admin.master.target.edit-target')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Target');
    }

    public function updateTarget(){
        $this->validate([
            'target.name' => 'required|string|max:255',
        ]);

        $target = Target::findOrFail($this->target['id']);

        try {
            DB::beginTransaction();

            $target->update($this->target);

            DB::commit();

            session()->flash('toastMessage', 'Data berhasil diedit');
            session()->flash('toastType', 'success');

        } catch (\Exception $e) {
            DB::rollBack();

            session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
            session()->flash('toastType', 'error');
        }

        return redirect()->to('master_target');
    }

    public function redirectToAdd()
    {
        return redirect()->to('master_target');
    }
}
