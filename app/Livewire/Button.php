<?php

namespace App\Livewire;

use Livewire\Component;

class Button extends Component
{
    public $size;
    public $type;
    public $outlined;
    public $additionalClass;
    public $colors;
    public $content;

    public function mount($size = 'sm', $type = 'button', $outlined = false, $additionalClass = '', $colors = 'primary', $content = '')
    {
        $this->size = $size;
        $this->type = $type;
        $this->outlined = $outlined;
        $this->additionalClass = $additionalClass;
        $this->colors = $colors;
        $this->content = $content;
    }

    public function render()
    {
        return view('livewire.button')->layout('app');
    }
}
