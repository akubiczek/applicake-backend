<?php

namespace App\Queue;

use App\Queue\Jobs\DatabaseJob;
use App\Services\TenantManager;

class DatabaseQueue extends \Illuminate\Queue\DatabaseQueue
{
    /**
     * Overrides default method to inject `tenant_id`
     * @param string|null $queue
     * @param string $payload
     * @param int $availableAt
     * @param int $attempts
     * @return array
     */
    protected function buildDatabaseRecord($queue, $payload, $availableAt, $attempts = 0)
    {
        $queueRecord = [
            'queue' => $queue,
            'attempts' => $attempts,
            'reserved_at' => null,
            'available_at' => $availableAt,
            'created_at' => $this->currentTime(),
            'payload' => $payload,
        ];

        $tenantManager = resolve(TenantManager::class);
        if ($tenantManager->getTenant()) {
            $queueRecord['tenant_id'] = $tenantManager->getTenant()->id;
        }

        return $queueRecord;
    }

    /**
     * Overrides default method to use my own DatabaseJob
     * @param string $queue
     * @param \Illuminate\Queue\Jobs\DatabaseJobRecord $job
     * @return DatabaseJob|\Illuminate\Queue\Jobs\DatabaseJob
     */
    protected function marshalJob($queue, $job)
    {
        $job = $this->markJobAsReserved($job);

        return new DatabaseJob(
            $this->container, $this, $job, $this->connectionName, $queue
        );
    }

}
