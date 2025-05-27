<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use App\Models\User;
use Livewire\Component;
use App\Models\Referente;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Referentes extends Component
{

    use WithPagination;
    use ComponentesTrait;
    use WithFileUploads;

    public $roles = [];
    public $candidatos = [];

    public Referente $modelo_editar;
    public $avatar;

    protected function rules(){
        return [
            'modelo_editar.nombre' => 'required',
            'modelo_editar.telefono' => 'required',
            'avatar' => 'nullable',
            'modelo_editar.candidato_id' => 'required',
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.telefono' => 'teléfono',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar =  Referente::make();
    }

    public function abrirModalEditar(Referente $modelo){

        $this->resetearTodo();

        Flux::modal('modal')->show();

        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function guardar(){

        $this->validate();

        if(Referente::where('nombre', $this->modelo_editar->name)->first()){

            $this->dispatch('mostrarMensaje', ['error', "El referente " . $this->modelo_editar->name . " ya esta registrado."]);

            $this->resetearTodo();

            return;

        }

        try {

            DB::transaction(function () {

                if($this->avatar){

                    $this->modelo_editar->avatar = $this->avatar->store('/', 'avatars');

                }

                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->save();

                Flux::toast(variant: 'success', text:'El referente se creó con éxito.');

            });

            $this->resetearTodo();

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al crear referente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                if($this->avatar){

                    if($this->modelo_editar->avatar)
                        Storage::disk('avatars')->delete($this->modelo_editar->avatar);

                    $this->modelo_editar->avatar = $this->avatar->store('/', 'avatars');

                }

                $this->modelo_editar->save();

                Flux::toast(variant: 'success', text:"El referente se actualizó con éxito.");

            });

            $this->resetearTodo();

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al actualizar referente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $referente = Referente::find($this->selected_id);

            $referente->delete();

            $this->resetearTodo($borrado = true);

            Flux::toast(variant: 'success', text:"El referente se eliminó con éxito.");

        } catch (\Throwable $th) {

            Log::error("Error al borrar referente por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    #[Computed]
    public function referentes(){

        return Referente::with('creadoPor:id,name', 'candidato:id,name')
                    ->where('nombre', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('telefono', 'LIKE', '%' . $this->search . '%')
                    ->orWhere(function($q){
                        return $q->whereHas('candidato', function($q){
                            return $q->where('name', 'LIKE', '%' . $this->search . '%');
                        });
                    })
                    ->when(auth()->user()->hasRole(['Candidato']), function($q){
                        $q->where('candidato_id', auth()->id());
                    })
                    ->when(auth()->user()->hasRole(['Supervisor','Telefonista', 'Capturista']), function($q){
                        $q->where('candidato_id', auth()->user()->candiadto_id);
                    })
                    ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
                    ->paginate($this->pagination);

    }

    public function mount(){

        $this->crearModeloVacio();

        $this->candidatos = User::whereHas('roles', function($q){
                                        $q->where('name', 'Candidato');
                                    })
                                    ->where('status', 'activo')
                                    ->orderBy('name')
                                    ->get();

    }

    public function render()
    {
        return view('livewire.admin.referentes');
    }
}
