<?php

namespace App\Queue;

use App\Queue\Connectors\DatabaseConnector;

class QueueServiceProvider extends \Illuminate\Queue\QueueServiceProvider
{
    /**
     * Overrides default method to use my own DatabaseConnector
     * @param \Illuminate\Queue\QueueManager $manager
     */
    protected function registerDatabaseConnector($manager)
    {
        $manager->addConnector('database', function () {
            return new DatabaseConnector($this->app['db']);
        });
    }
}
