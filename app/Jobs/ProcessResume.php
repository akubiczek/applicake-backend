<?php

namespace App\Jobs;

use App\Models\Candidate;
use App\Utils\ResumeParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessResume implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var Candidate
     */
    protected $candidate;

    protected $override;

    /**
     * Create a new job instance.
     *
     * @param Candidate $candidate
     * @param bool      $override
     */
    public function __construct(Candidate $candidate, $override = false)
    {
        $this->candidate = $candidate;
        $this->override = $override;
    }

    /**
     * Execute the job.
     *
     * @throws \Exception
     *
     * @return void
     */
    public function handle()
    {
        if (substr($this->candidate->path_to_cv, -4) == '.pdf') {
            $outputFile = str_replace('.pdf', '_avatar.jpg', $this->candidate->path_to_cv);

            if ($this->override || Storage::disk('s3')->missing($outputFile)) {
                if (ResumeParser::extractPhoto($this->candidate->path_to_cv, $outputFile)) {
                    $this->candidate->photo_path = $outputFile;
                }

                $this->candidate->photo_extraction = new \DateTime();
                $this->candidate->save();
            }
        }
    }
}
