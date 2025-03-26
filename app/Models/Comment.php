<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment' , 'approved' , 'parent_id' , 'commentable_type' , 'commentable_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function child()
    {
        return $this->hasMany(Comment::class , 'parent_id' , 'id');
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
