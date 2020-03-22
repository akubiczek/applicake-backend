<?php

// @formatter:off

/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models {
    /**
     * App\Models\PredefinedMessage
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedMessage newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedMessage newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PredefinedMessage query()
     */
    class PredefinedMessage extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Note
     *
     * @property-read \App\Models\Candidate $candidate
     * @property-read \App\Models\User $user
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Note query()
     */
    class Note extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\StageMessageTemplate
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StageMessageTemplate newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StageMessageTemplate newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\StageMessageTemplate query()
     */
    class StageMessageTemplate extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Link
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link query()
     */
    class Link extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\User
     *
     * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
     * @property-read int|null $clients_count
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
     * @property-read int|null $tokens_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
     */
    class User extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Role
     *
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
     * @property-read int|null $users_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
     */
    class Role extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\FormField
     *
     * @property-read \App\Models\Recruitment $recruitment
     * @method static bool|null forceDelete()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField newQuery()
     * @method static \Illuminate\Database\Query\Builder|\App\Models\FormField onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FormField query()
     * @method static bool|null restore()
     * @method static \Illuminate\Database\Query\Builder|\App\Models\FormField withTrashed()
     * @method static \Illuminate\Database\Query\Builder|\App\Models\FormField withoutTrashed()
     */
    class FormField extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Tenant
     *
     * @property int $id
     * @property string $subdomain
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereSubdomain($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tenant whereUpdatedAt($value)
     */
    class Tenant extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Recruitment
     *
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidate[] $candidates
     * @property-read int|null $candidates_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormField[] $formFields
     * @property-read int|null $form_fields_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PredefinedMessage[] $predefinedMessages
     * @property-read int|null $predefined_messages_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Source[] $sources
     * @property-read int|null $sources_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recruitment newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recruitment newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Recruitment query()
     */
    class Recruitment extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Candidate
     *
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Activity[] $activities
     * @property-read int|null $activities_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
     * @property-read int|null $messages_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Note[] $notes
     * @property-read int|null $notes_count
     * @property-read \App\Models\Recruitment $recruitment
     * @property-read \App\Models\Source $source
     * @property-read \App\Models\Stage $stage
     * @method static bool|null forceDelete()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Candidate newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Candidate newQuery()
     * @method static \Illuminate\Database\Query\Builder|\App\Models\Candidate onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Candidate query()
     * @method static bool|null restore()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Candidate unseen()
     * @method static \Illuminate\Database\Query\Builder|\App\Models\Candidate withTrashed()
     * @method static \Illuminate\Database\Query\Builder|\App\Models\Candidate withoutTrashed()
     */
    class Candidate extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Activity
     *
     * @property-read \App\Models\Candidate $candidate
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Activity query()
     */
    class Activity extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Source
     *
     * @property-read \App\Models\Recruitment $recruitment
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Source query()
     */
    class Source extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Stage
     *
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidate[] $candidates
     * @property-read int|null $candidates_count
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Stage query()
     */
    class Stage extends \Eloquent
    {
    }
}

namespace App\Models {
    /**
     * App\Models\Message
     *
     * @property-read \App\Models\Candidate $candidate
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
     */
    class Message extends \Eloquent
    {
    }
}

