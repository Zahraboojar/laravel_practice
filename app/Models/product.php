<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [
        'title' , 'description' , 'price' , 'inventory' , 'view_count'
    ];
}
