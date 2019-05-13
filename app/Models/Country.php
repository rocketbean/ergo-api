<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [];

    public function toArray() {
      return [
        'value' => $this->id,
        'label' => $this->nicename,
        'description' => $this->iso3,
      ];
    }
}
