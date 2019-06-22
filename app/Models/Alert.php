<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Alert extends Model
{
    protected $guarded = [];
    protected $with = ['subject'];
    public function user () {
      return $this->belongsTo(User::class);
    }
    /**
     * Get all of the owning notificationable models.
     */
    public function alertable()
    {
        return $this->morphTo();
    }

    public function subject()
    {
        return $this->morphTo('subject', 'subjectable_type', 'subjectable_id');
    }

    /**
     * Get all of the owning notificationable models.
     */
    // public function subject()
    // {
    //   var_dump($this); exit();
    //   return $this->belongsTo((string) $this->subjectable_type, 'subjectable_id');
    //   // var_dump($query); exit(); 
    // }
}
