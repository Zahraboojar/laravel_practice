<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_type',
        'phone_number',
        'is_staff',
        'is_superuser',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function activecode()
    {
        return $this->hasMany(Active_code::class);
    }
    
    public function isSuperUser()
    {
        return $this->is_superuser;
    }

    public function isStaffUser()
    {
        return $this->is_staff;
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

    public function HasTwoFactorAuth($key): bool
    {
        return $this->two_factor_auth === $key;
    }

    public function permission()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($roles)
    {
        return $roles->intersect($this->role)->all();
    }

    public function hasPermission($permission)
    {
        return $this->permission->contains('name', $permission->name) || $this->hasRole($permission->role);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
