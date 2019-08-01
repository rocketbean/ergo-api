<?php

namespace App\Models;

use App\Models\JobRequest;
use App\Models\Location;
use App\Models\Photo;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];
    protected $with = ['primary', 'photos', 'files', 'videos'];

     public function owner () {
      return $this->belongsTo(User::class, 'user_id');
     }

     public function location () {
      return $this->belongsTo(Location::class);
     }

     public function Jobrequests () {
      return $this->hasMany(JobRequest::class);
     }

    /**
     * Get all the [location] tagged to [Property].
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
     * Get all of the [files] for the [property].
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    /**
     * Get all of the [users] for the [property].
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(PropertyUser::class)
            ->accessor("role");
    }

    /**
     * Get all of the [users] for the [property].
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    


    /**
     * Get all of the [users] for the [property].
     */
    public static function RelateTo(Property $property, $model, $relation)
    {
        if(!$property->{$relation}->contains($model['id']))
            $property->{$relation}()->attach($model['id']);

    }
}
