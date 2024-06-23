<?php

namespace App\Livewire;

use Livewire\Component;

class Auth extends Component
{
    public $credential;
    public $password;
    public $showNavbar = false;
    public $showFooter = false;
    public function render()
    {
        return view('livewire.auth.auth')
        ->layout('components.layouts.app', ['showNavbar' => $this->showNavbar], ['showFooter' => $this->showFooter])
        ->title('UNG Survey - Auth');
    }
    public function handleLogin(){
       dd($this->password, $this->credential);
    }
}
