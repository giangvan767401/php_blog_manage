<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;

class News extends Model
{
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'image_path',
        'status',
        'admin_note',
        'is_hot',
        'views',
    ];

    protected $casts = [
        'is_hot' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}


