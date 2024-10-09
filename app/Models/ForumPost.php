<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id', 'image_path', 'youtube_link'];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'forum_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
