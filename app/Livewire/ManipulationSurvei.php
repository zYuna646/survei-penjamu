<?php

namespace App\Livewire;

use App\Models\Survey;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ManipulationSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';

    public $survei;
    public $respon;
    public $jumlah;
    public $tidakMemuaskan;
    public $cukupMemuaskan;
    public $memuaskan;
    public $sangatMemuaskan;
    public $sisa;

    public function mount($id)
    {
        $this->survei = Survey::findOrFail($id);
        $table = $this->survei->id;
        $this->respon = DB::table($table)->get()->toArray();
    }

    public function saveManipulation(){
        $this->calculateSisa();
        
        if($this->sisa != 0){
            dd($this->sisa);
        }
    }

    public function calculateSisa()
    {
        $total = $this->tidakMemuaskan + $this->cukupMemuaskan + $this->memuaskan + $this->sangatMemuaskan;
        $this->sisa = $this->jumlah - $total;
    }


    public function render()
    {
        return view('livewire.admin.master.survei.manipulation-survei')
            ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
            ->title('UNG Survey - Survei ' . $this->survei['name']);
    }
}
