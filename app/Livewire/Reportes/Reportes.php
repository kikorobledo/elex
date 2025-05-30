<?php

namespace App\Livewire\Reportes;

use Flux\Flux;
use App\Models\User;
use App\Models\Seccion;
use Livewire\Component;
use App\Models\Referido;
use App\Models\Referente;
use Livewire\WithPagination;
use App\Exports\ReferidosExport;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class Reportes extends Component
{

    use WithPagination;

    public $candidatos;
    public $referentes;
    public $search_seccion;

    public $municipio;
    public $referente_id;
    public $seccion_id;
    public $candidato_id;
    public $status;

    public function exportar(){

        try {

            return Excel::download(new ReferidosExport($this->municipio, $this->referente_id, $this->seccion_id, $this->candidato_id, $this->status), 'Reporte_de_referidos_' . now()->format('d-m-Y') . '.xlsx');

        } catch (\Throwable $th) {

            Log::error("Error generar archivo de reporte de referidos por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);

            Flux::toast(variant: 'danger', text:"Ha ocurrido un error.");

        }

    }

    #[Computed]
    public function referidos(){

        return Referido::with('referente', 'seccion', 'candidato')
                                    ->when($this->municipio && $this->municipio != '', function($q){
                                        $q->where('municipio', 'like', '%' . $this->municipio . '%');
                                    })
                                    ->when($this->status, function ($q){
                                        $q->where('status', $this->status);
                                    })
                                    ->when($this->referente_id, function ($q){
                                        $q->where('referente_id', $this->referente_id);
                                    })
                                    ->when($this->seccion_id, function($q){
                                        $q->where('seccion_id', $this->seccion_id);
                                    })
                                    ->when($this->candidato_id, function($q){
                                        $q->where('candidato_id', $this->candidato_id);
                                    })
                                    ->paginate(10);

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

    public function mount(){

        $this->candidatos = User::whereHas('roles', function($q){
                                        $q->where('name', 'Candidato');
                                    })
                                    ->where('status', 'activo')
                                    ->orderBy('name')
                                    ->get();

        $this->referentes = Referente::orderBy('nombre')->get();

    }

    public function render()
    {
        return view('livewire.reportes.reportes');
    }
}
