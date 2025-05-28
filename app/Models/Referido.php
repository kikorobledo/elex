<?php

namespace App\Models;

use App\Models\User;
use App\Models\Seccion;
use App\Models\Referente;
use App\Models\Comentario;
use Illuminate\Database\Eloquent\Model;

class Referido extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'indigo',
            'buzón' => 'yellow',
            'no contesta' => 'orange',
            'no validó referencia' => 'red',
            'validó referencia' => 'green',
            'invitado' => 'pink',
            'reforzado' => 'sky',
            'votado' => 'gray',
            'tel. error' => 'red',
        ][$this->status] ?? 'gray';
    }

    public function creadoPor(){
        return $this->belongsTo(User::class);
    }

    public function seccion(){
        return $this->belongsTo(Seccion::class);
    }

    public function referente(){
        return $this->belongsTo(Referente::class);
    }

    public function candidato(){
        return $this->belongsTo(User::class);
    }

    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

}
