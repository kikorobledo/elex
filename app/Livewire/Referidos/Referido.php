<?php

namespace App\Livewire\Referidos;

use Flux\Flux;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use App\Models\Referido as ModelReferido;

class Referido extends Component
{

    public ModelReferido $referido;

    public $estado;
    public $comentario;

    protected function rules(){
        return [
            'estado' => 'required',
            'comentario' => 'required',
         ];
    }

    public function guardar(){

        $this->validate();

        try {

            $this->referido->comentarios()->create([
                'status' => $this->estado,
                'contenido' => $this->comentario,
                'creado_por' => auth()->id(),
                'candidato_id' => $this->referido->candidato_id
            ]);

            $this->referido->update(['status' => $this->estado]);

            $this->referido->load('comentarios.creadoPor');

            Flux::toast(variant: 'success', text:'El comentario se creó con éxito.');

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al crear ccomentario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

        }

    }

    public function render()
    {
        return view('livewire.referidos.referido');
    }
}
