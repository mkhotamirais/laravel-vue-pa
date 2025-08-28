<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tourroute extends Model
{
    protected $fillable = ['name', 'slug'];

    public function tourpackages()
    {
        return $this->belongsToMany(Tourpackage::class, 'tourpackage_tourroute');
    }
}
