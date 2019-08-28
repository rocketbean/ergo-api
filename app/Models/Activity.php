<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    /**
     * Get the owning loggable model.
     */
    public function loggable()
    {
        return $this->morphTo();
    }
    
    public function user () {
    	return $this->belongsTo(User::class,'user_id');
    }
}
