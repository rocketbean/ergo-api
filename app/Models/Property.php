<?php

namespace App\Models;

use Auth;
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

     public function jobrequests () {
            return $this->hasMany(JobRequest::class);
     }

     public function authorizeJobRequest () {
        if($this->authorized('show_jobrequests')) {
            return $this->hasMany(JobRequest::class);
        } else {
            return $this->hasMany(JobRequest::class)->where('user_id', Auth::user()->id);
        }
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
     * Get all of the [photos] for the [property].
     */
    public function primaryPhoto()
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
     * Activity relations.
     */
    public function activity()
    {
        return $this->morphOne(Activity::class, 'loggable');
    }

    /**
     * creates loggable acivity
     */
    public function logActivity(Array $data, $model)
    {
        $data['user_id'] = Auth::user()->id;
        $data['target_id'] = $model->id;
        $data['target_type'] = class_basename($model);
        return $this->activity()->create($data);
    }

    /**
     * Get all of the [users] for the [property].
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Get all of the [users] for the [property].
     */
    public function propertyUsers()
    {
        return $this->belongsToMany(User::class)
            ->using(PropertyUser::class)
            ->withPivot(['role_id', 'status'])
            ->as('propertyUsers');
    }

    /**
     * Get all of the [users] for the [property].
     */
    public static function RelateTo(Property $property, $model, $relation)
    {
        if(!$property->{$relation}->contains($model['id']))
            $property->{$relation}()->attach($model['id']);

    }

    /**
     * check if the bridge is authorized
     */
    public function authorized($rule, $user = false)
    {
        if(!$user) {
            $bridge = (new PropertyUser)->userBridge($this);
        } else {
            $bridge = (new PropertyUser)->bridge($user, $this);
        }
        return $bridge->role->permissions->contains(Permission::slug($rule));
    }

    /**
     * check if the bridge is authorized
     */
    public function role()
    {
        return (new PropertyUser)->userBridge($this);
    }

    /**
     * check if the bridge is authorized
     */
    public function push_notification($notification = '')
    {
        $users = [];
        foreach ($this->propertyUsers as $user) {
           $user->propertyUsers->load(['role']);
           if($this->authorized('receive_notifications', $user)) {
                if($user->id != Auth::user()->id) {
                    $user->notify($notification);
                }
           }
        }
    }
}
