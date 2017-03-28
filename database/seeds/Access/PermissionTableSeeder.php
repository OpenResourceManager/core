<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class PermissionTableSeeder
 */
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::table(config('access.permissions_table'))->truncate();
            DB::table(config('access.permission_role_table'))->truncate();
        } elseif (DB::connection()->getDriverName() == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.permissions_table'));
            DB::statement('DELETE FROM ' . config('access.permission_role_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.permissions_table') . ' CASCADE');
            DB::statement('TRUNCATE TABLE ' . config('access.permission_role_table') . ' CASCADE');
        }

        /**
         * Don't need to assign any permissions to administrator because the all flag is set to true
         * in RoleTableSeeder.php
         */

        /**
         * Misc Access Permissions
         */
        $permission_model = config('access.permission');
        $viewBackend = new $permission_model;
        $viewBackend->name = 'view-backend';
        $viewBackend->display_name = 'View Backend';
        $viewBackend->sort = 1;
        $viewBackend->created_at = Carbon::now();
        $viewBackend->updated_at = Carbon::now();
        $viewBackend->save();

        /**
         * Access Permissions
         */
        $permission_model = config('access.permission');
        $manageUsers = new $permission_model;
        $manageUsers->name = 'manage-users';
        $manageUsers->display_name = 'Manage Users';
        $manageUsers->sort = 2;
        $manageUsers->created_at = Carbon::now();
        $manageUsers->updated_at = Carbon::now();
        $manageUsers->save();

        $permission_model = config('access.permission');
        $manageRoles = new $permission_model;
        $manageRoles->name = 'manage-roles';
        $manageRoles->display_name = 'Manage Roles';
        $manageRoles->sort = 3;
        $manageRoles->created_at = Carbon::now();
        $manageRoles->updated_at = Carbon::now();
        $manageRoles->save();

        /**
         *
         * API Permissions
         *
         */

        $permissions = [
            [
                'name' => 'read-account',
                'display_name' => 'API: Read Account',
            ],
            [
                'name' => 'write-account',
                'display_name' => 'API: Write Account',
            ],
            [
                'name' => 'read-classified',
                'display_name' => 'API: Read Classified Attributes',
            ],
            [
                'name' => 'write-classified',
                'display_name' => 'API: Write Classified Attributes',
            ],
            [
                'name' => 'read-alias-account',
                'display_name' => 'API: Read Alias Account',
            ],
            [
                'name' => 'write-alias-account',
                'display_name' => 'API: Write Alias Account',
            ],
            [
                'name' => 'read-alias-classified',
                'display_name' => 'API: Read Classified Attributes on Alias Accounts',
            ],
            [
                'name' => 'write-alias-classified',
                'display_name' => 'API: Write Classified Attributes on Alias Accounts',
            ],
            [
                'name' => 'read-address',
                'display_name' => 'API: Read Address',
            ],
            [
                'name' => 'write-address',
                'display_name' => 'API: Write Address',
            ],
            [
                'name' => 'read-building',
                'display_name' => 'API: Read Buildings',
            ],
            [
                'name' => 'write-building',
                'display_name' => 'API: Write Buildings',
            ],
            [
                'name' => 'read-campus',
                'display_name' => 'API: Read Campuses',
            ],
            [
                'name' => 'write-campus',
                'display_name' => 'API: Write Campuses',
            ],
            [
                'name' => 'read-country',
                'display_name' => 'API: Read Country',
            ],
            [
                'name' => 'write-country',
                'display_name' => 'API: Write Country',
            ],
            [
                'name' => 'read-course',
                'display_name' => 'API: Read Courses',
            ],
            [
                'name' => 'write-course',
                'display_name' => 'API: Write Courses',
            ],
            [
                'name' => 'read-department',
                'display_name' => 'API: Read Departments',
            ],
            [
                'name' => 'write-department',
                'display_name' => 'API: Write Departments',
            ],
            [
                'name' => 'read-duty',
                'display_name' => 'API: Read Duty',
            ],
            [
                'name' => 'write-duty',
                'display_name' => 'API: Write Duty',
            ],
            [
                'name' => 'read-email',
                'display_name' => 'API: Read Email',
            ],
            [
                'name' => 'write-email',
                'display_name' => 'API: Write Email',
            ],
            [
                'name' => 'read-mobile-carrier',
                'display_name' => 'API: Read Mobile Carrier',
            ],
            [
                'name' => 'write-mobile-carrier',
                'display_name' => 'API: Write Mobile Carrier',
            ],
            [
                'name' => 'read-mobile-phone',
                'display_name' => 'API: Read Mobile Phone',
            ],
            [
                'name' => 'write-mobile-phone',
                'display_name' => 'API: Write Mobile Phone',
            ],
            [
                'name' => 'read-room',
                'display_name' => 'API: Read Rooms',
            ],
            [
                'name' => 'write-room',
                'display_name' => 'API: Write Rooms',
            ],
            [
                'name' => 'read-state',
                'display_name' => 'API: Read State',
            ],
            [
                'name' => 'write-state',
                'display_name' => 'API: Write State',
            ],
        ];

        $count = 4;
        foreach ($permissions as $permission) {
            $permission_model = config('access.permission');
            $p = new $permission_model;
            $p->name = $permission['name'];
            $p->display_name = $permission['display_name'];
            $p->sort = $count;
            $p->created_at = Carbon::now();
            $p->updated_at = Carbon::now();
            $p->save();
            $count++;
        }

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}