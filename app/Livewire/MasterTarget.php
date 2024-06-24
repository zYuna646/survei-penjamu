<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Target;

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

        Target::create([
            'name' => $this->target['nama'],
        ]);    
    
        return redirect()->to('master_target');
    }

    public function deleteTarget($id)
    {
        Target::findOrFail($id)->delete();
       return redirect()->to('master_target');
    }
}
