<?php

namespace Tests\Feature;

use App\Events\CandidateStageChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CandidateTest extends TestCase
{
    use RefreshDatabase;

    private $candidate = [
        'first_name' => 'Adam',
        'last_name' => 'Testowy',
        'email' => 'adam@kubiczek.eu',
        'phone_number' => '+48600600600',
        'additional_info' => 'Bierzcie mnie i nikogo innego!',
        'key' => 'XXXYYZ1',
    ];

    /** @test */
    public function candidate_was_created_event_fired()
    {
        Event::fake();
        $this->seed();
        $this->seed(\ExampleRecruitments::class);
        Storage::fake('cv');

        $this->candidate['file'] = UploadedFile::fake()->create('cv.pdf', 30);

        $this->post('/api/candidates', $this->candidate)
            ->assertStatus(201)
            ->assertJsonFragment([
            'first_name' => $this->candidate['first_name'],
            'last_name' => $this->candidate['last_name'],
            'email' => $this->candidate['email'],
            'phone_number' => $this->candidate['phone_number'],
        ]);

        Event::assertDispatched(CandidateStageChanged::class, function ($event) {
            return $event->candidate->first_name === $this->candidate['first_name'];
        });
    }
}
