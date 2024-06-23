<?php

namespace App\Livewire;

use Livewire\Component;

class AdminDashboard extends Component
{
    public $showNavbar = true;
    public $showFooter = true;

    public $cards = [
        [
            'icon' => 'fas fa-university',
            'value' => 12,
            'label' => 'Total Fakultas'
        ],
        [
            'icon' => 'fas fa-graduation-cap',
            'value' => 24,
            'label' => 'Total Prodi'
        ],
        [
            'icon' => 'fas fa-clipboard-check',
            'value' => 50,
            'label' => 'Total Survey'
        ],
        [
            'icon' => 'fas fa-users',
            'value' => 560,
            'label' => 'Total Responden'
        ],
    ];

    public function render()
    {
        return view('livewire.admin.admin-dashboard')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar , 'showFooter' => $this->showFooter])
        ->title('UNG Survey - Admin Dashboard');;
    }
    
}
