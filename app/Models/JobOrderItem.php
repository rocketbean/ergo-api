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
    protected $guarded = [];

    public function user () {
      return $this->belongsTo(User::class);
    }

    public function joborder () {
      return $this->belongsTo(JobOrder::class);
    }

    public function jobrequest () {
      return $this->belongsTo(JobRequest::class);
    }

    public function jobrequestitem () {
      return $this->belongsTo(JobRequestItem::class);
    }

    public function property () {
      return $this->belongsTo(Property::class);
    }

    public function supplier () {
      return $this->belongsTo(Supplier::class);
    }
}
