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

        /**
         *
         *
         * Permissions
         *
         *
         */

        /**
         * Account
         */
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


        // This permission applies to user related objects ie: SSN & password
        $readClassifiedExtended = Permission::create([
            'name' => 'read-classified',
            'display_name' => 'Read Classified Attributes',
            'description' => 'Can write classified account attributes.',
        ]);


        // This permission applies to user related objects ie: SSN & password
        $writeClassifiedExtended = Permission::create([
            'name' => 'write-classified',
            'display_name' => 'Write Classified Attributes',
            'description' => 'Can write classified account attributes.',
        ]);

        /**
         * Address
         */
        $readAddress = Permission::create([
            'name' => 'read-address',
            'display_name' => 'Read Address',
            'description' => 'Can read address attributes.',
        ]);

        $writeAddress = Permission::create([
            'name' => 'write-address',
            'display_name' => 'Write Address',
            'description' => 'Can write address attributes.',
        ]);

        /**
         * Building
         */
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

        /**
         * Campus
         */
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

        /**
         * Country
         */
        $readCountry = Permission::create([
            'name' => 'read-country',
            'display_name' => 'Read Country',
            'description' => 'Can read country attributes.',
        ]);

        $writeCountry = Permission::create([
            'name' => 'write-country',
            'display_name' => 'Write Country',
            'description' => 'Can write country attributes.',
        ]);

        /**
         * Course
         */
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

        /**
         * Department
         */
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

        /**
         * Duty
         */
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

        /**
         * Email
         */
        $readEmail = Permission::create([
            'name' => 'read-email',
            'display_name' => 'Read Email',
            'description' => 'Can read email attributes.',
        ]);

        $writeEmail = Permission::create([
            'name' => 'write-email',
            'display_name' => 'Write Email',
            'description' => 'Can write email attributes.',
        ]);

        /**
         * Mobile Carrier
         */
        $readMobileCarrier = Permission::create([
            'name' => 'read-mobile-carrier',
            'display_name' => 'Read Mobile Carrier',
            'description' => 'Can read mobile carrier attributes.',
        ]);

        $writeMobileCarrier = Permission::create([
            'name' => 'write-mobile-carrier',
            'display_name' => 'Write Mobile Carrier',
            'description' => 'Can write mobile carrier attributes.',
        ]);

        /**
         * Mobile Phone
         */
        $readMobilePhone = Permission::create([
            'name' => 'read-mobile-phone',
            'display_name' => 'Read Mobile Phone',
            'description' => 'Can read mobile phone attributes.',
        ]);

        $writeMobilePhone = Permission::create([
            'name' => 'write-mobile-phone',
            'display_name' => 'Write Mobile Phone',
            'description' => 'Can write mobile phone attributes.',
        ]);

        /**
         * Room
         */
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

        /**
         * State
         */
        $readState = Permission::create([
            'name' => 'read-state',
            'display_name' => 'Read State',
            'description' => 'Can read states attributes.',
        ]);

        $writeState = Permission::create([
            'name' => 'write-state',
            'display_name' => 'Write State',
            'description' => 'Can write states attributes.',
        ]);


        /**
         *
         *
         * Roles
         *
         *
         */

        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Has all permissions.'
        ]);

        $serviceRole = Role::create([
            'name' => 'service-admin',
            'display_name' => 'Service Admin',
            'description' => 'Has all permissions. Used for service accounts.'
        ]);

        $accountAdmin = Role::create([
            'name' => 'account-admin',
            'display_name' => 'Account Admin',
            'description' => 'Has permissions to manage account attributes, including classified attributes.'
        ]);

        $accountManager = Role::create([
            'name' => 'account-manager',
            'display_name' => 'Account Manager',
            'description' => 'Has permissions to manage account attributes.'
        ]);


        $adminRole->attachPermissions(Permission::all());
        $serviceRole->attachPermission(Permission::all());
        $accountAdmin->attachPermission([

        ]);

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
