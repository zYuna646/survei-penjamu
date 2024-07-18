<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth as Login;
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
       if (Login::attempt(['email' => $this->credential, 'password' => $this->password])) {
        session()->regenerate();
        $role = Login::user()->role->slug;
        return redirect()->to('dashboard');
        
       }else{
       }
    }
}
