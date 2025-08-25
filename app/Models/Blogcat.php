<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blogcat extends Model
{
    protected $fillable = ['name', 'slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
