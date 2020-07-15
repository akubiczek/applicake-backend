<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruitmentUser extends Model
{
    protected $connection = 'tenant';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'recruitment_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['recruitment_id', 'user_id', 'creator_id'];
}
