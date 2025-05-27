<?php

namespace App\Traits;

use Flux\Flux;

trait ComponentesTrait{

    public $modalBorrar = false;
    public $crear = false;
    public $editar = false;
    public $search;
    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $pagination = 10;
    public $selected_id;
    public $fields = ['modalBorrar', 'crear', 'editar'];

    public function sort($column) {

        if ($this->sortBy === $column) {

            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

        } else {

            $this->sortBy = $column;

            $this->sortDirection = 'asc';

        }
    }

    public function updatedPagination():void
    {
        $this->resetPage();
    }

    public function updatingSearch():void
    {
        $this->resetPage();
    }

    public function resetearTodo($borrado = false):void
    {

        $this->reset($this->fields);
        $this->resetErrorBag();
        $this->resetValidation();

        if($borrado)
            $this->crearModeloVacio();

    }

    public function abrirModalBorrar($id):void
    {

        $this->modalBorrar = true;

        $this->selected_id = $id;

    }

    public function abrirModalCrear():void
    {

        $this->resetearTodo();

        Flux::modal('modal')->show();

        $this->crear =true;

        if($this->modelo_editar->getKey())
            $this->crearModeloVacio();

    }

    public function mount():void
    {

        $this->crearModeloVacio();

    }

}
