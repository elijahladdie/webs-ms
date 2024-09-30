<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['website_id', 'title', 'description'];

    public function website()
    {
        return $this->belongsTo(Website::class,  'website_id', 'website_id');
    }
    public function sentPosts()
    {
        return $this->hasMany(SentPost::class, 'post_id', 'post_id'); 
    }
}
