<?php

namespace App\UUD\LDAP\Providers;

use App\Model\Building;
use App\Model\Campus;
use App\Model\Course;
use App\Model\Department;
use App\Model\Role;
use App\Model\User;
use Illuminate\Support\Facades\Log;
use App\UUD\LDAP\LdapBridge;
use Illuminate\Support\ServiceProvider;

class LdapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // While a User is being created
        User::creating(function ($user) {
            $time_start = microtime(true);
            // Create a new bridge object
            $bridge = new LdapBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                $debug = $bridge->debugging;
                // Pass the user model to creation function
                $bridge->create_user($user);
                // Close LDAP connection
                $bridge->demolish();
                if ($debug) Log::debug('LDAP Create User took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to execute.');
                Die();
            }
        });

        // While a Role is being created
        Role::creating(function ($role) {
            // Create a new bridge object
            $bridge = new LdapBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // If roles map to an OU then verify that it is created
                if ($bridge->roles_map_to_ou) $bridge->map_role_ou($role->name);
                // Make a group for that role if needed
                if ($bridge->create_groups && $bridge->roles_are_groups) $bridge->map_group($role->name, 'Roles');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a Department is being created
        Department::creating(function ($department) {
            // Create a new bridge object
            $bridge = new LdapBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Make a group for that department if needed
                if ($bridge->create_groups && $bridge->departments_are_groups) $bridge->map_group($department->name, 'Departments');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a Course is being created
        Course::creating(function ($course) {
            // Create a new bridge object
            $bridge = new LdapBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Make a group for that course if needed
                if ($bridge->create_groups && $bridge->courses_are_groups) $bridge->map_group($course->name, 'Courses');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a Campus is being created
        Campus::creating(function ($campus) {
            // Create a new bridge object
            $bridge = new LdapBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Make a group for that campus if needed
                if ($bridge->create_groups && $bridge->campuses_are_groups) $bridge->map_group($campus->name, 'Campuses');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a Building is being created
        Building::creating(function ($building) {
            // Create a new bridge object
            $bridge = new LdapBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Make a group for that building if needed
                if ($bridge->create_groups && $bridge->buildings_are_groups) $bridge->map_group($building->name, 'Buildings');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        /**
         * @todo Manage User:creating and User:created methods
         */
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
