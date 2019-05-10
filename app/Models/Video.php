<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Property;
use App\Models\Supplier;
use App\Models\JobRequest;
use App\Models\JobOrder;

class Video extends Model
{
    protected $guarded = [];

    public function users () {
      return $this->morphedByMany(User::class, 'videoable');
    }

    public function properties () {
      return $this->morphedByMany(Property::class, 'videoable');
    }

    public function suppliers () {
      return $this->morphedByMany(Supplier::class, 'videoable');
    }

    public function jobrequests () {
      return $this->morphedByMany(JobRequest::class, 'videoable');
    }

    public function joborders () {
      return $this->morphedByMany(JobOrder::class, 'videoable');
    }
}
