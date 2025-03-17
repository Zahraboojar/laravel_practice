<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'label'
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
