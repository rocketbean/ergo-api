<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\JobOrder;
use App\Models\JobRequest;
use App\Models\JobRequestItem;
use App\Models\Property;
use App\Models\Supplier;

class JobOrderItem extends Model
{
    protected $with = ['photos', 'videos', 'files', 'tags', 'jobrequestitem'];
    protected $guarded = [];

    public function user () {
      return $this->belongsTo(User::class);
    }

    public function joborder () {
      return $this->belongsTo(JobOrder::class, 'job_request_id');
    }

    public function jobrequest () {
      return $this->belongsTo(JobRequest::class, 'job_request_id');
    }

    public function jobrequestitem () {
      return $this->belongsTo(JobRequestItem::class, 'job_request_item_id');
    }

    public function property () {
      return $this->belongsTo(Property::class);
    }

    public function supplier () {
      return $this->belongsTo(Supplier::class);
    }

    public function approve () {
      return $this->update(['status_id' => 3]);
    }

    public function deny () {
      return $this->update(['status_id' => 0]);
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


    /**
     * Get all of the photos for the jobrequest.
     */
    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachable');
    }

    /**
     * Get all of the [users] for the [property].
     */
    public static function RelateTo(JobOrderItem $joi, $model, $relation)
    {
        if(!$joi->{$relation}->contains($model['id']))
            $joi->{$relation}()->attach($model['id']);
    }
}
