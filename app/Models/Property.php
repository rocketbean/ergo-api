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

     public function user () {
      return $this->belongsTo(User::class);
     }

     public function location () {
      return $this->morphMany(Location::class, 'locationable');
     }

     public function Jobrequests () {
      return $this->hasMany(JobRequest::class);
     }

    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
    
    /**
     * Get all of the photos for the jobrequest.
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }
}
