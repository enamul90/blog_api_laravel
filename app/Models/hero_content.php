<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class hero_content extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'boldTitle',
        'dis',
        'videoButtonUrl',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
