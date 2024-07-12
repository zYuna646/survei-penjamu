<?php

namespace App\Livewire;

use Livewire\Component;

class CreateSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';
    

    public function render()
    {
        return view('livewire.admin.master.survei.create-survei')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Master Survei');
    }

    public $survei = ['name' => '']; // This should be initialized with the actual survey name
    public $aspeks = [
        ['name' => '', 'indikators' => [['name' => '']]]
    ];

    public function addAspek()
    {
        $this->aspeks[] = ['name' => '', 'indikators' => [['name' => '']]];
    }

    public function removeAspek($index)
    {
        unset($this->aspeks[$index]);
        $this->aspeks = array_values($this->aspeks); // reindex array
    }

    public function addIndikator($aspekIndex)
    {
        $this->aspeks[$aspekIndex]['indikators'][] = ['name' => ''];
    }

    public function removeIndikator($aspekIndex, $indikatorIndex)
    {
        unset($this->aspeks[$aspekIndex]['indikators'][$indikatorIndex]);
        $this->aspeks[$aspekIndex]['indikators'] = array_values($this->aspeks[$aspekIndex]['indikators']); // reindex array
    }

    protected $rules = [
        'survei.name' => 'required|string|max:255',
        'aspeks.*.name' => 'required|string|max:255',
        'aspeks.*.indikators.*.name' => 'required|string|max:255',
    ];

    public function updateSurvei(){
        dd($this->aspeks);
    }
    public function redirectToAdd()
    {
        return redirect()->to('master_survei');
    }
}
