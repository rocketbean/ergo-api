<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Photo;
use App\Models\Property;
use App\Models\JobRequest;
class JobRequestItem extends Model
{
    protected $guarded = [];

    public function user () {
      return $this->belongsTo(User::class);
    }

    public function property () {
      return $this->belongsTo(Property::class);
    }

    public function jobrequest () {
      return $this->belongsTo(JobRequest::class);
    }

    /**
     * Get all of the photos for the jobrequest.
     */
    public function photos()
    {
        return $this->morphToMany(Photo::class, 'photoable');
    }

    /**
     * Get all of the photos for the jobrequest.
     */
    public function attachPhoto(JobRequestItem $item, Photo $photo )
    {
        return $item->photos()->attach($photo->id);
    }
}
