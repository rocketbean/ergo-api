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

    protected $with = ['items', 'photos', 'files', 'videos', 'tags', 'joborders'];

    public function property () {
      return $this->belongsTo(Property::class);
    }

    public function user () {
      return $this->belongsTo(User::class);
    }

    public function approver() {
      return $this->belongsTo(User::class, 'approved_by');
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
        return $this->morphToMany(Video::class, 'videoable');
    }

    /**
     * Get all of the [files] for the [jobrequest].
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    /**
     * Get all of the photos for the jobrequest.
     */
    public function attachPhoto(JobRequest $jr, Photo $photo)
    {
        return $jr->photos()->attach($photo->id);
    }

    /**
     * Get all of the photos for the jobrequest.
     */
    public function joborders()
    {
        return $this->hasMany(Joborder::class);
    }


    /**
     * Get all of the [users] for the [property].
     */
    public static function RelateTo(JobRequest $jr, $model, $relation)
    {
        if(!$jr->{$relation}->contains($model['id']))
            $jr->{$relation}()->attach($model['id']);
    }

    /**
     * Get all of the [users] for the [property].
     */
    public static function Approve(JobRequest $jr, JobOrder $jo, User $user)
    {
      $jr->update([
        'status_id'     => 3,
        'job_order_id'  => $jo->id,
        'approved_by'   => $user->id,
      ]);
      return $jr;
    }
}
