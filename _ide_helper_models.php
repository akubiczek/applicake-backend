<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Activity
 *
 * @property-read \App\Models\Candidate $candidate
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
 */
	class Activity extends \Eloquent {}
}

namespace App\Models{
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
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate newQuery()
 * @method static \Illuminate\Database\Query\Builder|Candidate onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Candidate unseen()
 * @method static \Illuminate\Database\Query\Builder|Candidate withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Candidate withoutTrashed()
 */
	class Candidate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FormField
 *
 * @property-read \App\Models\Recruitment $recruitment
 * @method static \Illuminate\Database\Eloquent\Builder|FormField newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FormField newQuery()
 * @method static \Illuminate\Database\Query\Builder|FormField onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|FormField query()
 * @method static \Illuminate\Database\Query\Builder|FormField withTrashed()
 * @method static \Illuminate\Database\Query\Builder|FormField withoutTrashed()
 */
	class FormField extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Link
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Link query()
 */
	class Link extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Message
 *
 * @property-read \App\Models\Candidate $candidate
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 */
	class Message extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Note
 *
 * @property-read \App\Models\Candidate $candidate
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 */
	class Note extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PasswordReset
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $email
 * @property string $token
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordReset whereUpdatedAt($value)
 */
	class PasswordReset extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PredefinedMessage
 *
 * @property-read \App\Models\Recruitment $recruitment
 * @method static \Illuminate\Database\Eloquent\Builder|PredefinedMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PredefinedMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PredefinedMessage query()
 */
	class PredefinedMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Recruitment
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidate[] $candidates
 * @property-read int|null $candidates_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FormField[] $formFields
 * @property-read int|null $form_fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $grantedUsers
 * @property-read int|null $granted_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PredefinedMessage[] $predefinedMessages
 * @property-read int|null $predefined_messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Source[] $sources
 * @property-read int|null $sources_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stage[] $stages
 * @property-read int|null $stages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Recruitment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recruitment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recruitment query()
 */
	class Recruitment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\RecruitmentUser
 *
 * @method static \Illuminate\Database\Eloquent\Builder|RecruitmentUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecruitmentUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecruitmentUser query()
 */
	class RecruitmentUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Source
 *
 * @property-read \App\Models\Recruitment $recruitment
 * @method static \Illuminate\Database\Eloquent\Builder|Source newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Source newQuery()
 * @method static \Illuminate\Database\Query\Builder|Source onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Source query()
 * @method static \Illuminate\Database\Query\Builder|Source withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Source withoutTrashed()
 */
	class Source extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Stage
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidate[] $candidates
 * @property-read int|null $candidates_count
 * @method static \Illuminate\Database\Eloquent\Builder|Stage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage query()
 */
	class Stage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StageMessageTemplate
 *
 * @method static \Illuminate\Database\Eloquent\Builder|StageMessageTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StageMessageTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StageMessageTemplate query()
 */
	class StageMessageTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tenant
 *
 * @property int $id
 * @property string $subdomain
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TenantUser[] $tenantUsers
 * @property-read int|null $tenant_users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereSubdomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant whereUpdatedAt($value)
 */
	class Tenant extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Recruitment[] $grantedRecruitments
 * @property-read int|null $granted_recruitments_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserInvitation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserInvitation query()
 */
	class UserInvitation extends \Eloquent {}
}

namespace App{
/**
 * App\TenantUser
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $username
 * @property int $tenant_id
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TenantUser whereUsername($value)
 */
	class TenantUser extends \Eloquent {}
}

