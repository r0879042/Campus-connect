<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $dates = ['published_at'];
    protected $fillable = ['title', 'image', 'content', 'published_at'];
}
