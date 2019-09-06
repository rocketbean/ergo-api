<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SupplierUser extends Pivot
{
  protected $table = 'supplier_user';
  protected $with = ['role'];
  
  public function role () {
    return $this->belongsTo(Role::class);
  }
  
  public function permission () {
    return $this->belongsToMany(Permission::class);
  }

  public function bridge (User $user, Supplier $supplier) {
    return $this->where('user_id', $user->id)
            ->where('supplier_id', $supplier->id)
            ->first();
  }

  public function userBridge (Supplier $supplier) {
    return $this->where('user_id', Auth::user()->id)
            ->where('supplier_id', $supplier->id)
            ->first();
  }
    public function client () {
      return $this->belongsTo(Client::class);
    }
}
