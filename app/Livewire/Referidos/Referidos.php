<?php

namespace App\Livewire\Referidos;

use Flux\Flux;
use App\Models\User;
use App\Models\Seccion;
use Livewire\Component;
use App\Models\Referido;
use App\Models\Referente;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Referidos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $referentes = [];
    public $candidatos = [];
    public $search_seccion = '';
    public $status;

    public Referido $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.referente_id' => 'required',
            'modelo_editar.sexo' => 'required',
            'modelo_editar.nombre' => 'required',
            'modelo_editar.telefono' => 'required|numeric',
            'modelo_editar.domicilio' => 'required',
            'modelo_editar.colonia' => 'required',
            'modelo_editar.cp' => 'required',
            'modelo_editar.municipio' => 'required',
            'modelo_editar.seccion_id' => 'required',
            'modelo_editar.clave_electoral' => 'required|unique:referidos,clave_electoral,' . $this->modelo_editar->id,
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.telefono' => 'teléfono',
        'modelo_editar.referente_id' => 'referente',
        'modelo_editar.cp' => 'código postal',
        'modelo_editar.seccion_id' => 'sección',
        'modelo_editar.clave_electoral' => 'clave electoral',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar =  Referido::make();
    }

    public function abrirModalEditar(Referido $modelo){

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

                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->status = 'nuevo';
                $this->modelo_editar->imagen = 'nuevo';
                $this->modelo_editar->candidato_id = Referente::find($this->modelo_editar->referente_id)->candidato_id;
                $this->modelo_editar->save();

                Flux::toast(variant: 'success', text:'El referido se creó con éxito.');

            });

            $this->resetearTodo();

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al crear referido por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                $this->modelo_editar->candidato_id = Referente::find($this->modelo_editar->referente_id)->candidato_id;
                $this->modelo_editar->save();

                Flux::toast(variant: 'success', text:"El referido se actualizó con éxito.");

            });

            $this->resetearTodo();

            Flux::modal('modal')->close();

        } catch (\Throwable $th) {

            Log::error("Error al actualizar referido por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $referido = Referido::find($this->selected_id);

            $referido->delete();

            $this->resetearTodo($borrado = true);

            Flux::toast(variant: 'success', text:"El referido se eliminó con éxito.");

        } catch (\Throwable $th) {

            Log::error("Error al borrar referido por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

            $this->resetearTodo();
        }

    }

    #[Computed]
    public function secciones(){

        return Seccion::select('id', 'seccion', 'casilla', 'distrito_federal', 'municipio')
                        ->when($this->search_seccion != '', function($q){
                            $q->where('seccion', 'LIKE', '%' . $this->search_seccion . '%');
                        })
                        ->limit(20)
                        ->get();

    }

    #[Computed]
    public function referidos(){

        if(auth()->user()->hasRole('Telefonista')){

            return Referido::with('creadoPor:id,name', 'candidato:id,name', 'referente:id,nombre')
                        ->where('candidato_id', auth()->user()->candidato_id)
                        ->where('nombre', 'LIKE', '%' . $this->search . '%')
                        ->orWhere(function($q){
                            return $q->whereHas('referente', function($q){
                                return $q->where('nombre', 'LIKE', '%' . $this->search . '%');
                            });
                        })
                        ->orWhere(function($q){
                            return $q->whereHas('candidato', function($q){
                                return $q->where('name', 'LIKE', '%' . $this->search . '%');
                            });
                        })
                        ->inRandomOrder()
                        ->limit(5)
                        ->get();

        }else{

            return Referido::with('creadoPor:id,name', 'candidato:id,name', 'referente:id,nombre')
                        ->where('nombre', 'LIKE', '%' . $this->search . '%')
                        ->orWhere('status', 'LIKE', '%' . $this->search . '%')
                        ->orWhere(function($q){
                            return $q->whereHas('referente', function($q){
                                return $q->where('nombre', 'LIKE', '%' . $this->search . '%');
                            });
                        })
                        ->orWhere(function($q){
                            return $q->whereHas('candidato', function($q){
                                return $q->where('name', 'LIKE', '%' . $this->search . '%');
                            });
                        })
                        ->when(auth()->user()->hasRole(['Candidato']), function($q){
                            $q->where('candidato_id', auth()->id());
                        })
                        ->when(auth()->user()->hasRole(['Supervisor', 'Capturista']), function($q){
                            $q->where('candidato_id', auth()->user()->candiadto_id);
                        })
                        ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
                        ->paginate($this->pagination);

        }

    }

    public function mount(){

        $this->crearModeloVacio();

        $this->search = request()->query('status');

        $this->candidatos = User::whereHas('roles', function($q){
                                        $q->where('name', 'Candidato');
                                    })
                                    ->where('status', 'activo')
                                    ->orderBy('name')
                                    ->get();

        $this->referentes = Referente::orderBy('nombre')
                                    ->get();

    }

    public function render()
    {
        return view('livewire.referidos.referidos');
    }
}
