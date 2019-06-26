<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
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

    public function toArray() {
      return [
        'id' => $this->id,
        'user_id' => $this->user_id,
        'subject_id' => $this->subjectable_id,
        'subject_type' => $this->subjectable_type,
        'title' => $this->title,
        'message' => $this->message,
        'data' => unserialize($this->data),
        'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
        'subject' => $this->subject,

      ];
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
