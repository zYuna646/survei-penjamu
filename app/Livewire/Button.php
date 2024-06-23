<?php

namespace App\Livewire;

use Livewire\Component;

class Button extends Component
{
    public $size;
    public $type;
    public $outlined;
    public $customClass;
    public $colors;
    public $content;
    public $onclick;

    public function mount($size = 'sm', $type = 'button', $outlined = false, $customClass = '', $colors = 'primary', $content = '', $onclick ='')
    {
        $this->size = $size;
        $this->type = $type;
        $this->outlined = $outlined;
        $this->customClass = $customClass;
        $this->colors = $colors;
        $this->content = $content;
        $this->onclick = $onclick;
    }

    

    public function render()
    {
        return view('livewire.button')->layout('app');
    }
}
