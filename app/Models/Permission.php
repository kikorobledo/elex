<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

}
