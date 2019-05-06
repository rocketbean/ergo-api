<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
use App\Models\JobRequest;
use App\Models\Supplier;
class Tag extends Model
{
    protected $guarded = [];

    /**
     * Get all of the posts that are assigned this tag  [Property].
     */
    public function properties()
    {
        return $this->morphedByMany(Property::class, 'taggable');
    }

    /**
     * Get all of the posts that are assigned this tag [JobRequest].
     */
    public function jobrequests()
    {
        return $this->morphedByMany(JobRequest::class, 'taggable');
    }

    /**
     * Get all of the posts that are assigned this tag [Supplier].
     */
    public function suppliers()
    {
        return $this->morphedByMany(Supplier::class, 'taggable');
    }
}
