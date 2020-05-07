<?php

namespace App\Services;

use Illuminate\Database\Seeder;

abstract class TenantSeeder extends Seeder
{
    /**
     * The name of the default connection.
     *
     * @var string
     */
    protected $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public static function connection($connection)
    {
        return new static($connection);
    }

    /**
     * Set the default connection name.
     *
     * @param string $connection
     * @return void
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public abstract function run(\App\Models\Recruitment $recruitment);
//    {
//        throw new \Exception('Method `run` has not been implemented in delivered class');
//    }
}
