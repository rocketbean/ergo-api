<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Supplier;
use App\Models\JobRequest;
use App\Models\Property;
use App\Models\JobOrderitem;

class JobOrder extends Model
{
    protected $guarded = [];

    public function user() {
      return $this->belongsTo(User::class);
    }

    public function supplier() {
      return $this->belongsTo(Supplier::class);
    }

    public function jobrequest() {
      return $this->belongsTo(JobRequest::class);
    }

    public function property() {
      return $this->belongsTo(Property::class);
    }

    public function items() {
      return $this->hasMany(JobOrderitem::class);
    }
}
