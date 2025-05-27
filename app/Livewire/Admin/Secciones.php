<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use App\Models\Seccion;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
class Secciones extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $modelo_editar;

    public function crearModeloVacio(){
        $this->modelo_editar =  Seccion::make();
    }

    public function ver(Seccion $seccion){

        $this->modelo_editar = $seccion;

        Flux::modal('ver')->show();

    }

    #[Computed]
    public function secciones(){

        return Seccion::query()
                        ->where('seccion', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('distrito_federal', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('distrito_local', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('municipio', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('casilla', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('presidente', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('secretario_1', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('secretario_2', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('escrutador_1', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('escrutador_2', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('escrutador_3', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('escrutador_4', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('escrutador_5', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('escrutador_6', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('suplente_1', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('suplente_2', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('suplente_3', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('ubicacion', 'LIKE', '%' . $this->search . '%')
                        ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
                        ->paginate(20);

    }

    public function render()
    {
        return view('livewire.admin.secciones');
    }
}
