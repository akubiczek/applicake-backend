<?php

namespace App\Queue\Jobs;

use App\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DatabaseJob extends \Illuminate\Queue\Jobs\DatabaseJob
{
    public function fire()
    {
        if ($this->job->tenant_id) {
            $tenant = Tenant::findOrFail($this->job->tenant_id);
            Config::set('database.connections.tenant.database', 'tenant_' . $this->job->tenant_id);
            DB::purge('tenant');
        }

        parent::fire();
    }
}
