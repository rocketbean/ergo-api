<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];

    public function open_roles () {
    	return [
            [
                'name'        => 'Owner',
                'description' => 'Property Owner',
                'type'        => Property::class
            ],
            [
                'name'        => 'Admin',
                'description' => 'Property Administrator',
                'type'        => Property::class
            ],
            [
                'name'        => 'Tenant',
                'description' => 'Property Tenant',
                'type'        => Property::class
            ],
    	];
    }
}
