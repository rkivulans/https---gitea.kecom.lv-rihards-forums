<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Music extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'artist',
        'genre',
        'album',
        'year',
        'cover_image',
        'file_path',
    ];
}
