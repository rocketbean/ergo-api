<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Location;
use App\Models\JobRequest;
use App\Models\Tag;
use App\Models\Photo;

class Property extends Model
{
    protected $guarded = [];
    protected $with = ['primary'];

     public function owner () {
      return $this->belongsTo(User::class);
     }

     public function location () {
      return $this->belongsTo(Location::class);
     }

     public function Jobrequests () {
      return $this->hasMany(JobRequest::class);
     }

    /**
     * Get all of the tags for the post.
     */
     public function locations () {
      return $this->morphToMany(Location::class, 'locationable');
     }

    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    
    /**
     * Get all of the [photos] for the [property].
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }

    /**
     * Get all of the [photos] for the [property].
     */
    public function primary()
    {
        return $this->belongsTo(Photo::class, 'primary');
    }

    /**
     * Get all of the [videos] for the [property].
     */
    public function videos()
    {
        return $this->morphToMany(Video::class, 'videoable');
    }


    /**
     * Get all of the [users] for the [property].
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
