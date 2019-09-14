<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $with = ['permissions'];

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
                'type'        => '*',
                'permissions' => [
                    'publish_jobrequest', 'update_jobrequest', 'delete_jobrequest',
                    'approve_joborder', 'read_joborder', 'delete_joborder',
                    'approve_user', 'create_user', 'read_user', 'update_user', 'delete_user',
                    'show_jobrequests', 'update_jobrequests', 'receive_notifications'
                ]
            ],
            [
                'name'        => 'Tenant',
                'description' => 'Property Tenant',
                'type'        => Property::class,
                'permissions' => [
                    'read_joborder', 'delete_joborder',
                ]
            ],
            [
                'name'        => 'Custom',
                'description' => 'Customized permissions',
                'type'        => Property::class,
                'permissions' => [
                    'create_jobrequest', 'read_jobrequest',
                    'approve_joborder', 'read_joborder', 'delete_joborder',
                ]
            ],
            // suppliers
            [
                'name'        => 'Owner',
                'description' => 'Supplier Owner',
                'type'        => Supplier::class,
                'permissions' => '*'
            ],
            [
                'name'        => 'Admin',
                'description' => 'Supplier Administrator',
                'type'        => '*',
                'permissions' => [
                    'publish_jobrequest', 'update_jobrequest', 'delete_jobrequest',
                    'approve_joborder', 'read_joborder', 'delete_joborder',
                    'approve_user', 'create_user', 'read_user', 'update_user', 'delete_user',
                    'show_jobrequests', 'update_jobrequests', 'receive_notifications'
                ]
            ],
            [
                'name'        => 'Worker',
                'description' => 'Supplier Worker',
                'type'        => Supplier::class,
                'permissions' => [
                    'read_joborder', 'delete_joborder',
                ]
            ],
            [
                'name'        => 'Custom',
                'description' => 'Customized permissions',
                'type'        => Supplier::class,
                'permissions' => [
                    'create_jobrequest', 'read_jobrequest',
                    'approve_joborder', 'read_joborder', 'delete_joborder',
                ]
            ],
    	];
    }

    public function permissions () {
        return $this->belongsToMany(Permission::class);
    }
}
