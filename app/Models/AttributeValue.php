<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $fillable = ['value', 'attribute_id'];

    public function attributes()
    {
        return $this->belongsTo(Attribute::class);
    }
}
