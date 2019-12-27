<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_SUPERADMIN = 'SUPERADMIN';

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
