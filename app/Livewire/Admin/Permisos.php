<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use App\Models\Role;
use Livewire\Component;
use App\Models\Permission;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Permisos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $areas = [];

    public Permission $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.name' => 'required'
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.name' => 'nombre'
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = Permission::make();
    }

    public function abrirModalEditar(Permission $modelo){

        $this->resetearTodo();

        Flux::modal('modal')->show();

        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function guardar(){

        $this->validate();

        try {

            $this->modelo_editar->save();

            $this->resetearTodo();

            Flux::toast(variant: 'success', text:"El permiso se creó con éxito.");

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al crear permiso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            $this->modelo_editar->save();

            $this->resetearTodo();

            Flux::toast(variant: 'success', text:"El permiso se actualizó con éxito.");

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al actualizar permiso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $permiso = Permission::find($this->selected_id);

            $permiso->delete();

            $this->resetearTodo($borrado = true);

            Flux::toast(variant: 'success', text:"El permiso se eliminó con éxito.");

            Flux::modal('delete')->close();

        } catch (\Throwable $th) {

            Log::error("Error al borrar permiso por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();

        }

    }

    #[Computed]
    public function permisos(){

        return Permission::where('name', 'LIKE', '%' . $this->search . '%')
                            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
                            ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.permisos');
    }
}
