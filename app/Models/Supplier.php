<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Property;
use App\Models\Tag;
use App\Models\Location;
use App\Models\JobOrder;
use App\Models\Photo;

class Supplier extends Model
{

    /**
     * this guarded attributes cannot be mass assigned.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * automatically load relations upon call
     *
     * @var array
     */
    protected $with = [
        'primary'
    ];
    public function user () {
      return $this->belongsTo(User::class);
    }

     public function location () {
      return $this->morphMany(Location::class, 'locationable');
     }
     
    /**
     * Get all of the tags for the post.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Get all of the tags for the post.
     */
    public function joborders()
    {
        return $this->hasMany(JobOrder::class);
    }
    
    /**
     * Get all of the photos for the jobrequest.
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }

    /**
     * Get all of the [users] for the [property].
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    /**
     * Get [primary] for the [property].
     */
    public function primary()
    {
        return $this->belongsTo(Photo::class, 'primary');
    }
}
