<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoleAndPermission;
    use Impersonate;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'name', 'access', 'rank', 'website_id', 'department_id', 'antelope_status', 'temp_password', 'avatar', 'advanced_training', 'requirements_exempt', 'department_status', 'timezone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * This should stop all the dirty hackers from being able to takeover other users
     *
     * @return bool
     */
    public function canImpersonate()
    {
        $constants = \Config::get('constants');
        return $this->level() >= $constants['access_level']['superadmin'];
    }

    /**
     * This should stop all the superadmins from getting nosy
     *
     * @return bool
     */
    public function canBeImpersonated()
    {
        $constants = \Config::get('constants');
        return $this->level() != $constants['access_level']['superadmin'];
    }
}
