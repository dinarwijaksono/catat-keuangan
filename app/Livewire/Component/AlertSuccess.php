<?php

namespace App\Livewire\Component;

use Livewire\Component;

class AlertSuccess extends Component
{
    public $message;

    public $isHidden = true;

    public function getListeners()
    {
        return [
            'alert-show' => 'doShowAlert',
            'alert-hide' => 'doHideAlert',
        ];
    }

    public function doShowAlert($message)
    {
        $this->isHidden = false;

        $this->message = $message;
    }

    public function doHideAlert()
    {
        $this->isHidden = true;
    }

    public function render()
    {
        return view('livewire.component.alert-success');
    }
}
