<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SelectWithSearch extends Component
{
    public $options = [
        '1' => 'Opsi 1',
        '2' => 'Opsi 2',
        '3' => 'Opsi 3',
        '4' => 'Opsi 4',
        '5' => 'Opsi 5',
        '6' => 'Opsi 6',
        '7' => 'Opsi 7',
        '8' => 'Opsi 8',
    ];
    
    public function render()
    {
        return view('components.select-with-search');
    }
}
