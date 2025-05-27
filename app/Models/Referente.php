<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Referente extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function creadoPor(){
        return $this->belongsTo(User::class);
    }

    public function candidato(){
        return $this->belongsTo(User::class, 'candidato_id');
    }

    public function avatarUrl(){

        return $this->avatar
                ? Storage::disk('avatars')->url($this->avatar)
                : null;

    }

}
