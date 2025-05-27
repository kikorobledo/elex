<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Referido;
use App\Models\Referente;

class Dashboard extends Component
{

    public $referentes;
    public $referidos;

    public function mount(){

        $this->referentes = Referente::count();

        $this->referidos = Referido::count();

    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
