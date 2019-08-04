<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PropertyUser extends Pivot 
{
  protected $table = "property_user";
  protected $guarded = [];
	protected $with = ['role', 'permission'];
  
  public function role () {
    return $this->belongsTo(Role::class);
  }
  
  public function permission () {
    return $this->belongsToMany(Permission::class);
  }
}
