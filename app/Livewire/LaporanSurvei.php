<?php

namespace App\Livewire;

use App\Models\Survey;
use Livewire\Component;

class LaporanSurvei extends Component
{
    public $survei;

    public function render()
    {
        return view('livewire.admin.report.laporan-survei');
    }
}
