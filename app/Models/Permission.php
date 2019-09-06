<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  protected $guarded = [];
  public function open_permissions () {
    return [
          [
              'name'            => 'Publish',
              'slug'            => 'publish_jobrequest',
              'description'     => 'Permission to publish own jobrequest',
              'type'            => JobRequest::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          [
              'name'            => 'Update',
              'slug'            => 'update_jobrequest',
              'description'     => 'Permission to Update own jobrequest',
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
              'name'            => 'Invite',
              'slug'            => 'invite_user',
              'description'     => 'Permission to invite',
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
              'slug'            => 'update_jobrequests',
              'description'     => 'permission to update all jobrequests',
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

          [
              'name'            => 'Notify',
              'slug'            => 'receive_notifications',
              'description'     => 'receive notifications from all jobrequests',
              'type'            => Property::class,
              'permission_type' => PropertyUser::class,
              'group'           => Property::class
          ],
          // supplier's permissions
          [
              'name'            => 'Publish',
              'slug'            => 'publish_jobrequest',
              'description'     => 'Permission to publish own jobrequest',
              'type'            => JobOrder::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          [
              'name'            => 'Update',
              'slug'            => 'update_joborder',
              'description'     => 'Permission to Update own JobOrder',
              'type'            => JobOrder::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          [
              'name'            => 'Delete',
              'slug'            => 'delete_joborder',
              'description'     => 'Permission to Delete',
              'type'            => JobOrder::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          // Users
          [
              'name'            => 'Approve',
              'slug'            => 'approve_user',
              'description'     => 'Permission to approve',
              'type'            => User::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          [
              'name'            => 'Invite',
              'slug'            => 'invite_user',
              'description'     => 'Permission to invite',
              'type'            => User::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          [
              'name'            => 'Read Only',
              'slug'            => 'read_user',
              'description'     => 'Permission to view',
              'type'            => User::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          [
              'name'            => 'Update',
              'slug'            => 'update_user',
              'description'     => 'Permission to Update',
              'type'            => User::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          [
              'name'            => 'Delete',
              'slug'            => 'delete_user',
              'description'     => 'Permission to Delete',
              'type'            => User::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          // joborders
          [
              'name'            => 'Approve',
              'slug'            => 'approve_joborder',
              'description'     => 'Permission to approve',
              'type'            => JobOrder::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          [
              'name'            => 'Read Only',
              'slug'            => 'read_joborder',
              'description'     => 'Permission to view',
              'type'            => JobOrder::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          [
              'name'            => 'Delete',
              'slug'            => 'delete_joborder',
              'description'     => 'Permission to Delete',
              'type'            => JobOrder::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
          //properties
          [
              'name'            => 'Show',
              'slug'            => 'show_joborders',
              'description'     => 'show all JobOrders',
              'type'            => Supplier::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],

          [
              'name'            => 'Update',
              'slug'            => 'update_joborders',
              'description'     => 'permission to update all jobrequests',
              'type'            => Supplier::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],

          [
              'name'            => 'Update',
              'slug'            => 'update_settings',
              'description'     => 'allow update Supplier settings',
              'type'            => Supplier::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],

          [
              'name'            => 'Notify',
              'slug'            => 'receive_notifications',
              'description'     => 'receive notifications from all jobrequests',
              'type'            => Supplier::class,
              'permission_type' => SupplierUser::class,
              'group'           => Supplier::class
          ],
    ];
  }

  public static function slug ($slug) {
    return Permission::where('slug', $slug)->first();
  }
}
