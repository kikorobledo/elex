<?php

namespace App\Models;

use App\Models\User;
use App\Models\Referido;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue',
            'buzón' => 'yellow',
            'no contesta' => 'orange',
            'no validó referencia' => 'red',
            'validó referencia' => 'green',
            'invitado' => 'pink',
            'reforzado' => 'red',
            'votado' => 'gray',
        ][$this->status] ?? 'gray';
    }

    public function referido(){
        return $this->belongsTo(Referido::class);
    }

    public function creadoPor(){
        return $this->belongsTo(User::class, 'creado_por');
    }

}
