<?php

namespace App\Livewire;

use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManipulationSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $dataSurvei;
    public $data;
    public $userRole;

    public function mount($id)
    {
        $user = Auth::user();
        $this->userRole = $user->role->slug;

        $this->dataSurvei = Survey::where('id', $id)->first();
        $aspekCollection = $this->dataSurvei->aspek;
        $data = [];
        foreach ($aspekCollection as $aspek) {
            $data[$aspek->id][0] = $aspek;
            $data[$aspek->id][1] = $aspek->indicator;
        }
        $this->data = $data;
    }


    public function render()
    {
        return view('livewire.admin.master.survei.manipulation-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Manipulasi Survei'. $this->dataSurvei['name']);
    }
}
