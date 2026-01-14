<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'short_dis',
        'category_id',
        'cover_image'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id'); 
    }

    public function description()
    {
        return $this->hasOne(BlogDescription::class, 'blog_id', 'id');
    }

}
