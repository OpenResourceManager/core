<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class EntrustTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $readDuty = Permission::create([
            'name' => 'read-duty',
            'display_name' => 'Read Duty',
            'description' => 'Can read duty attributes.',
        ]);

        $writeDuty = Permission::create([
            'name' => 'write-duty',
            'display_name' => 'Write Duty',
            'description' => 'Can write duty attributes.',
        ]);

        $readAccount = Permission::create([
            'name' => 'read-account',
            'display_name' => 'Read Account',
            'description' => 'Can read account attributes.',
        ]);

        $writeAccount = Permission::create([
            'name' => 'write-account',
            'display_name' => 'Write Account',
            'description' => 'Can write account attributes.',
        ]);

        /**
         * This permission applies to user related objects ie phone numbers, emails
         */
        $readAccountExtended = Permission::create([
            'name' => 'read-account-ext',
            'display_name' => 'Read Account Extended',
            'description' => 'Can read extended account attributes.',
        ]);

        /**
         * This permission applies to user related objects ie phone numbers, emails
         */
        $writeAccountExtended = Permission::create([
            'name' => 'write-account-ext',
            'display_name' => 'Write Account Extended',
            'description' => 'Can write extended account attributes.',
        ]);

        /**
         * This permission applies to user related objects ie: SSN & password
         */
        $readClassifiedExtended = Permission::create([
            'name' => 'read-classified',
            'display_name' => 'Read Classified Attributes',
            'description' => 'Can write classified account attributes.',
        ]);

        /**
         * This permission applies to user related objects ie: SSN & password
         */
        $writeClassifiedExtended = Permission::create([
            'name' => 'write-classified',
            'display_name' => 'Write Classified Attributes',
            'description' => 'Can write classified account attributes.',
        ]);


        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Has all permissions.'
        ]);

        $admin->attachPermissions(Permission::all());
    }
}
