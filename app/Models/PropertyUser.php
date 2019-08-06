<?php

namespace App\Models;

use Auth;
use App\Models\Property;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PropertyUser extends Pivot 
{
  protected $table = "property_user";
  protected $guarded = [];
	protected $with = ['role'];
  
  public function role () {
    return $this->belongsTo(Role::class);
  }
  
  public function permission () {
    return $this->belongsToMany(Permission::class);
  }

  public function bridge (User $user, Property $property) {
    return $this->where('user_id', $user->id)
            ->where('property_id', $property->id)
            ->first();
  }

  public function userBridge (Property $property) {
    return $this->where('user_id', Auth::user()->id)
            ->where('property_id', $property->id)
            ->first();
  }
}
