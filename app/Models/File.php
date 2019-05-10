<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    public function users () {
      return $this->morphedByMany(User::class, 'fileable');
    }

    public function properties () {
      return $this->morphedByMany(Property::class, 'fileable');
    }

    public function suppliers () {
      return $this->morphedByMany(Supplier::class, 'fileable');
    }

    public function jobrequests () {
      return $this->morphedByMany(JobRequest::class, 'fileable');
    }

    public function joborders () {
      return $this->morphedByMany(JobOrder::class, 'fileable');
    }
}
