<?php

namespace App\Livewire;

use App\Models\Survey;
use Livewire\Component;

class LaporanSurvei extends Component
{
    public $survei;
    public function mount($id){
        $survei = Survey::findOrFail($id);
        $this->survei = $survei->toArray();
    }

    public function render()
    {
        return view('livewire.admin.report.laporan-survei');
    }
}
