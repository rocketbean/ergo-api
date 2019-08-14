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

    protected $with = ['photos', 'videos', 'files', 'tags', 'joborderitem'];

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
    public function attachPhoto(JobRequestItem $item, Photo $photo )
    {
        return $item->photos()->attach($photo->id);
    }

    /**
     * Get all of the photos for the jobrequest.
     */
    public function approve(JobOrderItem $item)
    {
        return $this->update([
            'job_order_item_id' => $item->id,
            'status_id' => 3
        ]);
    }

    /**
     * Get all of the photos for the jobrequest.
     */
    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachable');
    }


    /**
     * Get all of the photos for the jobrequest.
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
     * Get all of the [videos] for the [property].
     */
    public function joborderitem()
    {
        return $this->belongsTo(JobOrderItem::class, 'job_order_item_id');
    }

    /**
     * Get all of the [videos] for the [property].
     */
    public function joborderitems()
    {
        return $this->hasMany(JobOrderItem::class);
    }

    /**
     * Get all of the [files] for the [property].
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'fileable');
    }

    /**
     * Get all of the [tags] for the jobrequest items.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }


    public static function RelateTo(JobRequestItem $item, $model, $relation)
    {
        if(!$item->{$relation}->contains($model['id'])) {
            $item->{$relation}()->attach($model['id']);
        }
    }
}
