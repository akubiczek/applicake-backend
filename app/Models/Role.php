<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $connection = 'tenant';

    const ROLE_SUPERADMIN = 'SUPERADMIN';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
