<?php

namespace App\Models;

use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as RoleSpatie;

class Role extends RoleSpatie
{
    use HasFactory;
}