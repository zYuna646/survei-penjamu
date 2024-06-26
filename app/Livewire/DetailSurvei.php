<?php

namespace App\Livewire;

use Livewire\Component;
use App\Charts\RecapChart;

class DetailSurvei extends Component
{
    public $showNavbar = true;
    public $showFooter = true;
    public $master = 'Survei';
    public $survey = [
        'name' => 'Survei kepuasan tenaga pendidik',
        'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras lacinia eros blandit lectus rhoncus, . ',
        'target' => 'Universitas',
        'type' => 'Reguler',
        'aspek_total' => 3,
      ];

    public function render(RecapChart $chart)
    {
        return view('livewire.admin.master.survei.detail-survei', ['chart'  => $chart->build($this->survey['name'])])
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar, 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Detil '. $this->survey['name']);
    }
}
