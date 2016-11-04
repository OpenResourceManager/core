<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Country;
use App\Http\Models\API\State;
use App\Http\Models\API\MobileCarrier;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Role;
use App\Permission;


class SystemEntitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

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

        $readCampus = Permission::create([
            'name' => 'read-campus',
            'display_name' => 'Read Campuses',
            'description' => 'Can read campus attributes.',
        ]);

        $writeCampus = Permission::create([
            'name' => 'write-campus',
            'display_name' => 'Write Campuses',
            'description' => 'Can write campus attributes.',
        ]);

        $readBuilding = Permission::create([
            'name' => 'read-building',
            'display_name' => 'Read Buildings',
            'description' => 'Can read building attributes.',
        ]);

        $writeBuilding = Permission::create([
            'name' => 'write-building',
            'display_name' => 'Write Buildings',
            'description' => 'Can write building attributes.',
        ]);

        $readRooms = Permission::create([
            'name' => 'read-rooms',
            'display_name' => 'Read Rooms',
            'description' => 'Can read rooms attributes.',
        ]);

        $writeRooms = Permission::create([
            'name' => 'write-rooms',
            'display_name' => 'Write Rooms',
            'description' => 'Can write rooms attributes.',
        ]);

        $readDepartments = Permission::create([
            'name' => 'read-departments',
            'display_name' => 'Read Departments',
            'description' => 'Can read departments attributes.',
        ]);

        $writeDepartments = Permission::create([
            'name' => 'write-departments',
            'display_name' => 'Write Departments',
            'description' => 'Can write departments attributes.',
        ]);

        $readCourses = Permission::create([
            'name' => 'read-courses',
            'display_name' => 'Read Courses',
            'description' => 'Can read courses attributes.',
        ]);

        $writeCourses = Permission::create([
            'name' => 'write-courses',
            'display_name' => 'Write Courses',
            'description' => 'Can write courses attributes.',
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
         * This permission applies to user related objects ie phone numbers, emails, address
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

        $adminUser = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@domain.tld',
            'password' => bcrypt('Cascade')
        ]);
        $adminUser->attachRole(Role::where('name', 'admin')->first());

        Country::insert(countryList());
        State::insert(stateList());
        MobileCarrier::insert(mobileCarrierList());
        Duty::insert(defaultDuties());

        Model::re();
    }
}
