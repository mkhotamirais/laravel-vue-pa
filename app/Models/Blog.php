<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'banner',
        'blogcat_id',
        'tags',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function blogcat()
    {
        return $this->belongsTo(Blogcat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['q'] ?? false) {
            $query->where(function ($q) {
                $search = strtolower(str_replace('-', ' ', request('q')));
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('tags', 'like', '%' . $search . '%');
            });
        }

        if ($filters['blogcat'] ?? false) {
            $slugCategory = $filters['blogcat'];
            $query->whereHas('blogcat', function ($q) use ($slugCategory) {
                $q->whereRaw('LOWER(slug) = ?', [strtolower($slugCategory)]);
            });
        }

        // if ($filters['tag'] ?? false) {
        //     $query->where('tags', 'like', '%' . request('tag') . '%');
        // }
    }
}
