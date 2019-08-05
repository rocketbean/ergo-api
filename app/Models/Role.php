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
                'type'        => Property::class,
                'permissions' => '*'
            ],
            [
                'name'        => 'Admin',
                'description' => 'Property Administrator',
                'type'        => '*'
                'permissions' => [
                    'approve_jobrequest', 'create_jobrequest', 'read_jobrequest', 'update_jobrequest', 'delete_jobrequest',
                    'approve_joborder', 'read_joborder', 'delete_joborder',
                    'approve_user', 'create_user', 'read_user', 'update_user', 'delete_user',
                    'show_jobrequests'
                ]
            ],
            [
                'name'        => 'Tenant',
                'description' => 'Property Tenant',
                'type'        => Property::class,
                'permissions' => [
                    'create_jobrequest', 'read_jobrequest',
                    'approve_joborder', 'create_joborder', 'read_joborder', 'update_joborder', 'delete_joborder',

                ]
            ],
            [
                'name'        => 'Custom',
                'description' => 'Customized permissions',
                'type'        => Property::class,
                'permissions' => [
                    'create_jobrequest', 'read_jobrequest',
                    'approve_joborder', 'create_joborder', 'read_joborder', 'update_joborder', 'delete_joborder',
                ]
            ],
    	];
    }

    public function permissions () {
        return $this->hasMany(Permission::class);
    }
}
