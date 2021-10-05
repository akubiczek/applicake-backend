<?php

namespace App\Services;

use Illuminate\Database\Seeder;

abstract class TenantAwareSeeder extends Seeder
{
    /**
     * The name of the default connection.
     *
     * @var string
     */
    protected $connection;

    public function __construct(string $connection)
    {
        $this->connection = $connection;
    }

    public static function connection(string $connection): TenantAwareSeeder
    {
        return new static($connection);
    }

    /**
     * Set the default connection name.
     *
     * @param string $connection
     *
     * @return void
     */
    public function setConnection(string $connection)
    {
        $this->connection = $connection;
    }

    abstract public function run();
}
