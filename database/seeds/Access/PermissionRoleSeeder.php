<?php

use Illuminate\Database\Seeder;
use App\Models\Access\Role\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Access\Permission\Permission;

/**
 * Class PermissionRoleSeeder
 */
class PermissionRoleSeeder extends Seeder
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
            DB::table(config('access.permission_role_table'))->truncate();
        } elseif (DB::connection()->getDriverName() == 'sqlite') {
            DB::statement('DELETE FROM ' . config('access.permission_role_table'));
        } else {
            //For PostgreSQL or anything else
            DB::statement('TRUNCATE TABLE ' . config('access.permission_role_table') . ' CASCADE');
        }


        $readAccount = Permission::where('name', 'read-account')->firstOrFail();
        $writeAccount = Permission::where('name', 'write-account')->firstOrFail();
        $readClassified = Permission::where('name', 'read-classified')->firstOrFail();
        $writeClassified = Permission::where('name', 'write-classified')->firstOrFail();
        $readAddress = Permission::where('name', 'read-address')->firstOrFail();
        $writeAddress = Permission::where('name', 'write-address')->firstOrFail();
        $readBuilding = Permission::where('name', 'read-building')->firstOrFail();
        $writeBuilding = Permission::where('name', 'write-building')->firstOrFail();
        $readCampus = Permission::where('name', 'read-campus')->firstOrFail();
        $writeCampus = Permission::where('name', 'write-campus')->firstOrFail();
        $readCountry = Permission::where('name', 'read-country')->firstOrFail();
        $writeCountry = Permission::where('name', 'write-country')->firstOrFail();
        $readCourses = Permission::where('name', 'read-course')->firstOrFail();
        $writeCourses = Permission::where('name', 'write-course')->firstOrFail();
        $readDepartments = Permission::where('name', 'read-department')->firstOrFail();
        $writeDepartments = Permission::where('name', 'write-department')->firstOrFail();
        $readDuty = Permission::where('name', 'read-duty')->firstOrFail();
        $writeDuty = Permission::where('name', 'write-duty')->firstOrFail();
        $readEmail = Permission::where('name', 'read-email')->firstOrFail();
        $writeEmail = Permission::where('name', 'write-email')->firstOrFail();
        $readMobileCarrier = Permission::where('name', 'read-mobile-carrier')->firstOrFail();
        $writeMobileCarrier = Permission::where('name', 'write-mobile-carrier')->firstOrFail();
        $readMobilePhone = Permission::where('name', 'read-mobile-phone')->firstOrFail();
        $writeMobilePhone = Permission::where('name', 'write-mobile-phone')->firstOrFail();
        $readRooms = Permission::where('name', 'read-room')->firstOrFail();
        $writeRooms = Permission::where('name', 'write-room')->firstOrFail();
        $readState = Permission::where('name', 'read-state')->firstOrFail();
        $writeState = Permission::where('name', 'write-state')->firstOrFail();


        Role::where('name', 'Service Viewer')->firstOrFail()->permissions()->sync([
            $readAccount->id,
            $readAddress->id,
            $readClassified->id,
            $readBuilding->id,
            $readCampus->id,
            $readCountry->id,
            $readCourses->id,
            $readDepartments->id,
            $readDuty->id,
            $readEmail->id,
            $readMobileCarrier->id,
            $readMobilePhone->id,
            $readRooms->id,
            $readState->id,
        ]);
        Role::where('name', 'Account Admin')->firstOrFail()->permissions()->sync([
            $readAccount->id,
            $writeAccount->id,
            $readMobilePhone->id,
            $writeMobilePhone->id,
            $readAddress->id,
            $writeAddress->id,
            $readEmail->id,
            $writeEmail->id,
            $readClassified->id,
            $writeClassified->id,
            $readDuty->id,
        ]);
        Role::where('name', 'Account Manager')->firstOrFail()->permissions()->sync([
            $readAccount->id,
            $writeAccount->id,
            $readMobilePhone->id,
            $writeMobilePhone->id,
            $readAddress->id,
            $writeAddress->id,
            $readEmail->id,
            $writeEmail->id,
            $readClassified->id,
            $readDuty->id,
        ]);
        Role::where('name', 'Account Viewer')->firstOrFail()->permissions()->sync([
            $readAccount->id,
            $readMobilePhone->id,
            $readAddress->id,
            $readEmail->id,
            $readClassified->id,
            $readDuty->id,
        ]);
        Role::where('name', 'Account Basic')->firstOrFail()->permissions()->sync([
            $readAccount->id,
            $readMobilePhone->id,
            $readAddress->id,
            $readEmail->id,
            $readDuty->id,
        ]);
        Role::where('name', 'Application Manager')->firstOrFail()->permissions()->sync([
            $readCountry->id,
            $writeCountry->id,
            $readState->id,
            $writeState->id,
            $readMobileCarrier->id,
            $writeMobileCarrier->id,
        ]);
        Role::where('name', 'Institution Manager')->firstOrFail()->permissions()->sync([
            $readCampus->id,
            $writeCampus->id,
            $readBuilding->id,
            $writeBuilding->id,
            $readDepartments->id,
            $writeDepartments->id,
            $writeCourses->id,
            $readCourses->id,
            $readDuty->id,
            $writeDuty->id,
            $readRooms->id,
            $writeRooms->id,
            $readAccount->id,
        ]);
        Role::where('name', 'Resource Viewer')->firstOrFail()->permissions()->sync([
            $readCampus->id,
            $readBuilding->id,
            $readRooms->id,
            $readDuty->id,
            $readDepartments->id,
            $readCourses->id,
            $readCountry->id,
            $readState->id,
            $readMobileCarrier->id,
        ]);

        /**
         *
         */

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}