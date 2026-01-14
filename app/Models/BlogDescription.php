<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class BlogDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_id',
        'description'
    ];
}