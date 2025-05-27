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

class Roles extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $permisos;

    public Role $modelo_editar;
    public $listaDePermisos = [];

    protected function rules(){
        return [
            'modelo_editar.name' => 'required'
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.name' => 'nombre',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar = Role::make();
    }

    public function abrirModalEditar(Role $modelo){

        $this->resetearTodo();

        Flux::modal('modal')->show();

        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        foreach($modelo['permissions'] as $permission){
            array_push($this->listaDePermisos, (string)$permission['id']);
        }

    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                $this->modelo_editar->save();

                $this->modelo_editar->permissions()->sync($this->listaDePermisos);

            });

            $this->resetearTodo();

            Flux::toast(variant: 'success', text:"El rol se creó con éxito.");

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al crear rol por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                $this->modelo_editar->save();

                $this->modelo_editar->permissions()->sync($this->listaDePermisos);

            });

            $this->resetearTodo();

            Flux::toast(variant: 'success', text:"El rol se actualizó con éxito.");

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al actualzar rol por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $role = Role::find($this->selected_id);

            $role->delete();

            $this->resetearTodo($borrado = true);

            Flux::toast(variant: 'success', text:"El rol se eliminó con éxito.");

            Flux::modal('delete')->close();

        } catch (\Throwable $th) {

            Log::error("Error al borrar rol por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();

        }

    }

    #[Computed]
    public function roles(){

        return Role::with('permissions')
                            ->where('name', 'LIKE', '%' . $this->search . '%')
                            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
                            ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'listaDePermisos');

        $this->permisos = Permission::all();

    }

    public function render()
    {
        return view('livewire.admin.roles');
    }
}
