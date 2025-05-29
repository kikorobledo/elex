<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use App\Models\Seccion;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.app')]
class Secciones extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.distrito_federal' => 'required',
            'modelo_editar.distrito_local' => 'required',
            'modelo_editar.municipio' => 'required',
            'modelo_editar.localidad' => 'required',
            'modelo_editar.seccion' => 'required',
            'modelo_editar.casilla' => 'required',
            'modelo_editar.presidente' => 'required',
            'modelo_editar.secretario_1' => 'nullable',
            'modelo_editar.secretario_2' => 'nullable',
            'modelo_editar.escrutador_1' => 'nullable',
            'modelo_editar.escrutador_2' => 'nullable',
            'modelo_editar.escrutador_3' => 'nullable',
            'modelo_editar.escrutador_4' => 'nullable',
            'modelo_editar.escrutador_5' => 'nullable',
            'modelo_editar.escrutador_6' => 'nullable',
            'modelo_editar.suplente_1' => 'nullable',
            'modelo_editar.suplente_2' => 'nullable',
            'modelo_editar.suplente_3' => 'nullable',
            'modelo_editar.ubicacion' => 'required',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar =  Seccion::make();
    }

    public function ver(Seccion $seccion){

        $this->modelo_editar = $seccion;

        Flux::modal('ver')->show();

    }

    public function abrirModalEditar(Seccion $modelo){

        $this->resetearTodo();

        Flux::modal('modal')->show();

        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                $this->modelo_editar->save();

                Flux::toast(variant: 'success', text:'La sección se creó con éxito.');

            });

            $this->resetearTodo();

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al crear sección por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                $this->modelo_editar->save();

                Flux::toast(variant: 'success', text:"La sección se actualizó con éxito.");

            });

            $this->resetearTodo();

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al actualizar sección por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

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
