<?php

namespace App\Jobs;

use App\Models\Candidate;
use App\Utils\ResumeParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessResume implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Candidate
     */
    protected $candidate;

    /**
     * Create a new job instance.
     *
     * @param Candidate $candidate
     * @param $tenantId
     */
    public function __construct(Candidate $candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        if (substr($this->candidate->path_to_cv, -4) == '.pdf') {
            $outputFile = str_replace('.pdf', '_avatar.jpg', $this->candidate->path_to_cv);
            $this->candidate->photo_extraction = new \DateTime();
            if (ResumeParser::extractPhoto($this->candidate->path_to_cv, $outputFile)) {
                $this->candidate->photo_path = $outputFile;
            }
            $this->candidate->save();
        }
    }
}
