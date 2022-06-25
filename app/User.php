<?php

namespace App;

use App\Models\region;
use App\Models\Store;
use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username', 'region_id', 'role_id', 'store_id', 'email', 'password','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function store()
    {
        return $this->hasOne(Store::class,'id', 'store_id' );
    }

    public function role()
    {
        return $this->hasOne(Role::class,'id', 'role_id' );
    }

    public function region()
    {
        return $this->hasOne(region::class, 'id', 'region_id');
    }

    public function scopegetUserRole($query)
    {
        return $query->join('role_user', 'users.id', '=', 'role_user.user_id')
                     ->join('roles', 'role_user.role_id', '=', 'roles.id')
                     ->select('users.id', 'users.name', 'users.username', 'users.email', 'roles.name as rolename');
    }

    public function stores()
    {
        return $this->hasManyThrough('App\Models\Store', 'App\Models\UserStore', 'user_id', 'id', 'id', 'store_id');
    }

    public function RoleUser()
    {
        return $this->hasOne(RoleUser::class, 'user_id', 'id');
    }

    public function userStore()
    {
        return $this->hasOne(UserStore::class, 'user_id', 'id');
    }
}
