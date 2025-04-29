<?php

namespace App\Livewire;

use Livewire\Component;

class EditIkm extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'IKM';

    public $ikm = [];

    public function mount($id)
    {
        // here the data should be mount
        // $this->ikm = ::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.master.ikm.edit-ikm')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Master IKM');
    }

    public function updateIkm()
    {
        // this should the data be mount
        // $ikm = ::findOrFail($this->['id']);

        $this->validate([
            'ikm.grade' => 'required|string|max:255',
            'ikm.operator' => 'required|string|max:255',
            'ikm.operator' => 'required|string|max:255',
        ]);

        // try {
            // DB::beginTransaction();


            // DB::commit();

            // session()->flash('toastMessage', 'Data berhasil diedit');
            // session()->flash('toastType', 'success');
        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     session()->flash('toastMessage', 'Terjadi kesalahan: ' . $e->getMessage());
        //     session()->flash('toastType', 'error');
        // }

        // return redirect()->to('master_ikm');
    }

    public function redirectToAdd()
    {
        return redirect()->to('master_ikm');
    }
}
