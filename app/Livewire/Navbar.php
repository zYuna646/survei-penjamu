<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    public $menuItems;

    public function mount()
    {
        // Ambil data menu dari file JSON atau sumber lainnya
        $menuJson = file_get_contents(resource_path('js/menu.json'));
        $menuData = json_decode($menuJson, true);
        // dd($menuData);

        // Tentukan peran pengguna, misalnya 'admin' atau 'user'
        $userRole = 'admin'; // Ganti dengan peran yang sesuai

        // Pastikan peran pengguna adalah kunci yang valid dalam data menu
        if (array_key_exists($userRole, $menuData)) {
            $this->menuItems = $menuData[$userRole];
        } else {
            // Jika peran pengguna tidak valid atau tidak memiliki menu yang terkait, atur $menuItems menjadi array kosong
            $this->menuItems = [];
        }
    }

    public function render()
    {
        return view('livewire.Navbar');
    }
}
