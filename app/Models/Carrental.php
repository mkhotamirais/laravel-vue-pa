<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrental extends Model
{
    protected $fillable = ["name", "slug", "price", "policy", "information", "banner", "category"];

    public function getRouteKeyName()
    {
        return "name";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeFilter($query, array $filters)
    {
        if ($filters['q'] ?? false) {
            $search = strtolower(str_replace('-', ' ', request('q')));
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($filters['carrentalcat'] ?? false) {
            $query->where('category', 'like', '%' . request('carrentalcat') . '%');
        }
    }
}
