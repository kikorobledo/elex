<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Usuarios extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $roles = [];
    public $candidatos = [];

    public User $modelo_editar;
    public $roleId;

    protected function rules(){
        return [
            'modelo_editar.name' => 'required',
            'modelo_editar.status' => 'required',
            'modelo_editar.email' => 'required|email|unique:users,email,' . $this->modelo_editar->id,
            'modelo_editar.telefono' => 'required',
            'roleId' => 'required',
            'modelo_editar.candidato_id' => Rule::requiredIf($this->roleId != "5")
         ];
    }

    protected $validationAttributes  = [
        'roleId' => 'rol',
        'modelo_editar.telefono' => 'teléfono',
        'modelo_editar.name' => 'nombre'
    ];

    public function crearModeloVacio(){
        $this->modelo_editar =  User::make();
    }

    public function abrirModalEditar(User $modelo){

        $this->resetearTodo();

        Flux::modal('modal')->show();

        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        if(isset($modelo['roles'][0]))
            $this->roleId = $modelo->roles()->pluck('id')[0];

    }

    public function guardar(){

        $this->validate();

        if(User::where('name', $this->modelo_editar->name)->first()){

            $this->dispatch('mostrarMensaje', ['error', "El usuario " . $this->modelo_editar->name . " ya esta registrado."]);

            $this->resetearTodo();

            return;

        }

        try {

            DB::transaction(function () {

                $this->modelo_editar->password = bcrypt('sistema');
                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->modelo_editar->roles()->attach($this->roleId);

                Flux::toast(variant: 'success', text:'El usuario se creó con éxito.');

            });

            $this->resetearTodo();

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al crear usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                $this->modelo_editar->save();

                $this->modelo_editar->roles()->sync($this->roleId);

                Flux::toast(variant: 'success', text:"El usuario se actualizó con éxito.");

            });

            $this->resetearTodo();

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al actualizar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $usuario = User::find($this->selected_id);

            $usuario->delete();

            $this->resetearTodo($borrado = true);

            Flux::toast(variant: 'success', text:"El usuario se eliminó con éxito.");

        } catch (\Throwable $th) {

            Log::error("Error al borrar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    public function resetearPassword($id){

        try{

            $usuario = User::find($id);

            $usuario->password = bcrypt('sistema');
            $usuario->save();

            $this->resetearTodo($borrado = true);

            Flux::toast(variant: 'success', text:"La contraseña se reestableció con éxito.");

        } catch (\Throwable $th) {

            Log::error("Error al resetear contraseña por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    #[Computed]
    public function usuarios(){

        return User::with('creadoPor:id,name', 'candidato:id,name')
                    ->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('telefono', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('status', 'LIKE', '%' . $this->search . '%')
                    ->orWhere(function($q){
                        return $q->whereHas('roles', function($q){
                            return $q->where('name', 'LIKE', '%' . $this->search . '%');
                        });
                    })
                    ->orWhere(function($q){
                        return $q->whereHas('candidato', function($q){
                            return $q->where('name', 'LIKE', '%' . $this->search . '%');
                        });
                    })
                    ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
                    ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'roleId');

        $this->roles = Role::where('id', '!=', 1)->select('id', 'name')->orderBy('name')->get();

        $this->candidatos = User::whereHas('roles', function($q){
                                        $q->where('name', 'Candidato');
                                    })
                                    ->where('status', 'activo')
                                    ->orderBy('name')
                                    ->get();

    }

    public function render()
    {
        return view('livewire.admin.usuarios');
    }
}
