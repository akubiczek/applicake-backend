<?php

namespace App\Console\Commands;

use App\Jobs\ProcessResume;
use App\Models\Candidate;
use App\Models\Tenant;
use App\Services\TenantManager;
use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\RuntimeException;

class ExtractPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'photo:extract {tenantId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $tenantManager;

    /**
     * Create a new command instance.
     *
     * @param TenantManager $tenantManager
     */
    public function __construct(TenantManager $tenantManager)
    {
        parent::__construct();

        $this->tenantManager = $tenantManager;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tenantId = $this->argument('tenantId');
        $tenant = Tenant::find($tenantId);

        if (!$tenant) {
            throw new RuntimeException('Tenant with ID = ' . $tenantId . ' does not exist.');
        }

        $this->tenantManager->setTenant($tenant);
        \DB::purge('tenant');

        $candidates = Candidate::whereNull('photo_extraction')->where('path_to_cv', '<>', '')->get();

        foreach ($candidates as $candidate) {
            $this->info('Parsing candidate id ' . $candidate->id);
            ProcessResume::dispatchNow($candidate);
        }
    }
}
