<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $with = [ 'photos', 'files', 'videos' ];

    protected $guarded = [];
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
     * Get all of the [files] for the [property].
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'fileable');
    }


    public static function RelateTo(Attachment $item, $model, $relation)
    {
        if(!$item->{$relation}->contains($model['id'])) {
            $item->{$relation}()->attach($model['id']);
        }
    }
}
