<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Property;
use App\Models\Supplier;
use App\Models\JobRequest;
use App\Models\JobOrder;

class Photo extends Model
{
    protected $guarded = [];

    public function users () {
      return $this->morphedByMany(User::class, 'photoable');
    }

    public function properties () {
      return $this->morphedByMany(Property::class, 'photoable');
    }

    public function suppliers () {
      return $this->morphedByMany(Supplier::class, 'photoable');
    }

    public function jobrequests () {
      return $this->morphedByMany(JobRequest::class, 'photoable');
    }

    public function joborders () {
      return $this->morphedByMany(JobOrder::class, 'photoable');
    }
}
