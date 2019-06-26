<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SupplierUser extends Model
{
  protected $table = 'supplier_user';
    public function client () {
      return $this->belongsTo(Client::class);
    }
}
