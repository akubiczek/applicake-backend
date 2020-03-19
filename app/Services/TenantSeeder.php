<?php

namespace App\Services;

use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * The name of the default connection.
     *
     * @var string
     */
    protected $connection;

    /**
     * Set the default connection name.
     *
     * @param string $name
     * @return void
     */
    public function setConnection($name)
    {
        $this->connection = $name;
    }
}
