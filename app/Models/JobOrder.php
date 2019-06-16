<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class JobOrder extends Model
{
    protected $guarded = [];

    protected $with = ['photos', 'files', 'videos','items'];

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function supplier() {
      return $this->belongsTo(Supplier::class);
    }

    public function jobrequest() {
      return $this->belongsTo(JobRequest::class);
    }

    public function property() {
      return $this->belongsTo(Property::class);
    }

    public function items() {
      return $this->hasMany(JobOrderitem::class);
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
     * Get all of the [files] for the [property].
     */
    public static function getEstimation($items)
    {
      $value = 0;
        foreach ($items as $item) {
          $value += (float) $item['estimation'];
        }
      return $value;
    }
}
