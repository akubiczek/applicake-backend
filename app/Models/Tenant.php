<?php

namespace App\Models;

use App\TenantUser;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    public function tenantUsers()
    {
        return $this->hasMany(TenantUser::class);
    }
}
