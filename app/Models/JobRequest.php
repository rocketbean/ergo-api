<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class JobRequest extends Model
{
    protected $guarded = [];
        //
    protected $with = ['items', 'photos', 'files', 'videos', 'tags', 'property'];

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
     * check if the bridge is authorized
     */
    public function scopeAuthorized()
    {
        // $bridge = (new PropertyUser)->userBridge($this);
        var_dump($this); exit;
        // return $bridge->role->permissions->contains(Permission::slug($rule));
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
     * Get all of the photos for the jobrequest.
     */
    public function joborder()
    {
        return $this->belongsTo(Joborder::class, 'job_order_id');
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
     * Set joborder as Approve status
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

    /**
     * Set joborder as Confirm status
     */
    public static function Confirm(JobRequest $jr, JobOrder $jo, User $user)
    {
      $jr->update([
        'status_id'     => 4,
      ]);
      return $jr;
    }

    /**
     * Set joborder as completed status
     */
    public static function Complete(JobRequest $jr, JobOrder $jo, User $user)
    {
      $jr->update([
        'status_id'     => 5,
      ]);
      return $jr;
    }

    /**
     * Set joborder as inProgress status
     */
    public static function InProgress(JobRequest $jr, JobOrder $jo, User $user)
    {
      $jr->update([
        'status_id'     => 4,
      ]);
      return $jr;
    }
}
