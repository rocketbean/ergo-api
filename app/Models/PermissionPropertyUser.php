<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionPropertyUser extends Model
{
    public function open_permissions () {
      return [
            [
                'name'            => 'Approve',
                'description'     => 'Permission to approve',
                'type'            => JobRequest::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Create',
                'description'     => 'Permission to Create',
                'type'            => JobRequest::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Read Only',
                'description'     => 'Permission to view',
                'type'            => JobRequest::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Update',
                'description'     => 'Permission to Update',
                'type'            => JobRequest::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Delete',
                'description'     => 'Permission to Delete',
                'type'            => JobRequest::class,
                'permission_type' => PropertyUser::class,
            ],
            // Users
            [
                'name'            => 'Approve',
                'description'     => 'Permission to approve',
                'type'            => User::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Create',
                'description'     => 'Permission to Create',
                'type'            => User::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Read Only',
                'description'     => 'Permission to view',
                'type'            => User::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Update',
                'description'     => 'Permission to Update',
                'type'            => User::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Delete',
                'description'     => 'Permission to Delete',
                'type'            => User::class,
                'permission_type' => PropertyUser::class,
            ],
            // joborders
            [
                'name'            => 'Approve',
                'description'     => 'Permission to approve',
                'type'            => JobOrder::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Create',
                'description'     => 'Permission to Create',
                'type'            => JobOrder::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Read Only',
                'description'     => 'Permission to view',
                'type'            => JobOrder::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Update',
                'description'     => 'Permission to Update',
                'type'            => JobOrder::class,
                'permission_type' => PropertyUser::class,
            ],
            [
                'name'            => 'Delete',
                'description'     => 'Permission to Delete',
                'type'            => JobOrder::class,
                'permission_type' => PropertyUser::class,
            ],
      ];
    }
}
