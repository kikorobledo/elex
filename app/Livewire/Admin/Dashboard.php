<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Models\Referido;
use App\Models\Referente;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $referentes;
    public $referidos;
    public $telefonistas;

    public $status;

    #[Computed]
    public function referidosLista(){

        return Referido::where('status', $this->status)->paginate(10);

    }

    public function mount(){

        $this->referentes = Referente::count();

        $this->referidos = Referido::select('status', DB::raw('count(*) count'))->groupBy('status')->get();

        $this->telefonistas = User::select('id', 'name')
                                    ->whereHas('roles', function($q){
                                        $q->where('name', 'Telefonista');
                                    })
                                    ->withCount('comentarios')
                                    ->get()
                                    ->sortBy('comentarios_count')
                                    ->reverse();

    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
