<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\User;
use App\Models\JobRequestItem;
use App\Models\Tag;
use App\Models\Photo;
use App\Models\Video;

class JobRequest extends Model
{
    protected $guarded = [];

    public function property () {
      return $this->belongsTo(Property::class);
    }

    public function user () {
      return $this->belongsTo(User::class);
    }

    /**
     * Get all of the tags for the jobrequest.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get all of the tags for the jobrequest.
     */
    public function items()
    {
        return $this->hasMany(JobRequestItem::class);
    }
    
    /**
     * Get all of the photos for the jobrequest.
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }

    /**
     * Get all of the videos for the jobrequest.
     */
    public function videos()
    {
        return $this->morphToMany(Video::class, 'photoable');
    }

    /**
     * Get all of the photos for the jobrequest.
     */
    public function attachPhoto(JobRequest $jr, Photo $photo)
    {
        return $jr->photos()->attach($photo->id);
    }
}
