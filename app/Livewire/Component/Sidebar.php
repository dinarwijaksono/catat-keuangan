<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Sidebar extends Component
{
    public $fullPath;
    public $path;

    public function mount()
    {
        $this->path = explode('/', $this->fullPath)[0];
    }

    public function render()
    {
        return view('livewire.component.sidebar');
    }
}
