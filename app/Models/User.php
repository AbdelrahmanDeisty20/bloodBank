<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;
    use HasRoles;
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    protected $append=['roles_list'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
// public function setPasswordAttribute($value)
// {
//     $this->attributes['password'] = bcrypt($value);
// }
    public function getRolesListAttribute()
{
    return $this->roles()->pluck('name', 'id')->toArray();
}
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
