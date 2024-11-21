<?php

namespace App\Livewire;

use Livewire\Component;

class HomeComponent extends Component
{
    public function render()
    {
        session()->flash('activePage', [
            'name' => 'Dashboard',
            'icon' => 'bx bx-tachometer'
        ]);
        return view('livewire.home-component');
    }
}