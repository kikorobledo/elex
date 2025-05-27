<?php

namespace App\Models;

use App\Models\Referido;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function referidos(){
        return $this->hasMany(Referido::class);
    }

}
