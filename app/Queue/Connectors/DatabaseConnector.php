<?php

namespace App\Queue\Connectors;

use App\Queue\DatabaseQueue;

class DatabaseConnector extends \Illuminate\Queue\Connectors\DatabaseConnector
{
    /**
     * Overrides default method to use my own DatabaseQueue.
     *
     * @param array $config
     *
     * @return DatabaseQueue|\Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        return new DatabaseQueue(
            $this->connections->connection($config['connection'] ?? null),
            $config['table'],
            $config['queue'],
            $config['retry_after'] ?? 60
        );
    }
}
