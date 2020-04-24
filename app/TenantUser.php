<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TenantUser extends Model
{
    public function tenant()
    {
        return $this->belongsTo('App\Models\Tenant');
    }
}
