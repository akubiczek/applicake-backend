<?php

namespace App\Providers;

use App\Http\Middleware\AppendTenantURL;
use App\Http\Middleware\IdentifyTenantByUsername;
use App\Http\Middleware\TranslateOAuthException;
use App\Models\Activity;
use App\Models\Candidate;
use App\Models\Message;
use App\Models\Note;
use App\Models\Recruitment;
use App\Models\RecruitmentUser;
use App\Policies\ActivityPolicy;
use App\Policies\CandidatePolicy;
use App\Policies\MessagePolicy;
use App\Policies\NotePolicy;
use App\Policies\RecruitmentPolicy;
use App\Policies\RecruitmentUserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Recruitment::class => RecruitmentPolicy::class,
        Candidate::class => CandidatePolicy::class,
        Note::class => NotePolicy::class,
        Message::class => MessagePolicy::class,
        Activity::class => ActivityPolicy::class,
        RecruitmentUser::class => RecruitmentUserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes(null, ['middleware' => [IdentifyTenantByUsername::class, AppendTenantURL::class, TranslateOAuthException::class]]);
    }
}
