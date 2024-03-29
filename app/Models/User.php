<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use HasApiTokens;
    use Notifiable;
    use SoftDeletes;

    protected $connection = 'tenant';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Find the user instance for the given username.
     *
     * @param string $username
     *
     * @return User
     */
    public function findForPassport($username)
    {
        return $this->where('email', $username)->where('pending_invitation', 0)->first();
    }

    /**
     * Used to determine access rights if a user has limited role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function grantedRecruitments()
    {
        return $this->belongsToMany(Recruitment::class)->withTimestamps();
    }
}
