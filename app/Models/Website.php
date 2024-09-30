<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;
    protected $table = 'websites';
    protected $primaryKey = 'website_id'; 

    protected $fillable = ['website_name', 'website_url'];
    
      public function subscriptions()
      {
          return $this->hasMany(Subscription::class, 'website_id', 'website_id'); 
      }
        
        public function posts()
        {
            return $this->hasMany(Post::class, 'post_id'); 
        }
}
