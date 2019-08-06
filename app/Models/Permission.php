<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  protected $guarded = [];
  public function open_permissions () {
    return [
          [
              'name'            => 'Approve',
              'slug'            => 'approve_jobrequest',
              'description'     => 'Permission to approve',
              'type'            => JobRequest::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Create',
              'slug'            => 'create_jobrequest',
              'description'     => 'Permission to Create',
              'type'            => JobRequest::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Read Only',
              'slug'            => 'read_jobrequest',
              'description'     => 'Permission to view',
              'type'            => JobRequest::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Update',
              'slug'            => 'update_jobrequest',
              'description'     => 'Permission to Update',
              'type'            => JobRequest::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Delete',
              'slug'            => 'delete_jobrequest',
              'description'     => 'Permission to Delete',
              'type'            => JobRequest::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          // Users
          [
              'name'            => 'Approve',
              'slug'            => 'approve_user',
              'description'     => 'Permission to approve',
              'type'            => User::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Create',
              'slug'            => 'create_user',
              'description'     => 'Permission to Create',
              'type'            => User::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Read Only',
              'slug'            => 'read_user',
              'description'     => 'Permission to view',
              'type'            => User::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Update',
              'slug'            => 'update_user',
              'description'     => 'Permission to Update',
              'type'            => User::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Delete',
              'slug'            => 'delete_user',
              'description'     => 'Permission to Delete',
              'type'            => User::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          // joborders
          [
              'name'            => 'Approve',
              'slug'            => 'approve_joborder',
              'description'     => 'Permission to approve',
              'type'            => JobOrder::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Read Only',
              'slug'            => 'read_joborder',
              'description'     => 'Permission to view',
              'type'            => JobOrder::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Update',
              'slug'            => 'update_joborder',
              'description'     => 'Permission to Update',
              'type'            => JobOrder::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Delete',
              'slug'            => 'delete_joborder',
              'description'     => 'Permission to Delete',
              'type'            => JobOrder::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          //properties
          [
              'name'            => 'Show',
              'slug'            => 'show_jobrequests',
              'description'     => 'show all jobrequests',
              'type'            => Property::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Update',
              'slug'            => 'update_settings',
              'description'     => 'allow update property settings',
              'type'            => Property::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
    ];
  }
}