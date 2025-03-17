<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'label'
    ];

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }

    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
