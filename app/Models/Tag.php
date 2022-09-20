<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'tag';
    }

    public function setTagAttribute($value)
    {
        return $this->attributes['tag'] = strtolower($value);
    }
}
