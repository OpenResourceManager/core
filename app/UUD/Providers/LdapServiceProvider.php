<?php

namespace App\UUD\Providers;

use App\Model\Building;
use App\Model\Campus;
use App\Model\Course;
use App\Model\Department;
use App\Model\Password;
use App\Model\PivotAction;
use App\Model\Role;
use App\Model\Room;
use App\Model\User;
use App\UUD\LDAP\UserBridge;
use Illuminate\Support\Facades\Log;
use App\UUD\LDAP\Bridge;
use Illuminate\Support\ServiceProvider;
use Mockery\Generator\StringManipulation\Pass\Pass;

class LdapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Any pivot action.
        PivotAction::creating(function (PivotAction $pivot_action) {
            // Create a new bridge object
            $bridge = new UserBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Are we looking for user related models?
                if ($pivot_action->class_2 == 'user') {
                    // Get the user model by it's primary key
                    $user = User::findOrFail($pivot_action->id_2);
                    // Create the pivot var
                    $pivot = null;
                    $class = null;
                    // Switch on the pivot
                    switch ($pivot_action->class_1) {
                        case 'course':
                            $pivot = Course::findOrFail($pivot_action->id_1);
                            $class = 'Courses';
                            break;
                        case 'department':
                            $pivot = Department::findOrFail($pivot_action->id_1);
                            $class = 'Departments';
                            break;
                        case 'role':
                            $pivot = Role::findOrFail($pivot_action->id_1);
                            $class = 'Roles';
                            break;
                        case 'room':
                            $pivot = Room::findOrFail($pivot_action->id_1)->building();
                            $class = 'Buildings';
                            break;
                        default:
                            $bridge->perform_ldap_error('Unsupported `class_1` supplied: ' . json_encode($pivot_action), __LINE__, __FILE__, __CLASS__);
                            break;
                    }
                    if (!empty($pivot)) {
                        // Depending on the kind of action we need to either add a user to a group or remove the user from the group
                        ($pivot_action->assign) ? $bridge->add_user_to_group($user, $pivot->name, $class) : $bridge->del_user_from_group($user, $pivot->name, $class);
                    } else {
                        $bridge->perform_ldap_error('Unsupported `class_1` supplied: ' . json_encode($pivot_action), __LINE__, __FILE__, __CLASS__);
                    }
                } else {
                    $bridge->perform_ldap_error('Unsupported `class_2` supplied: ' . json_encode($pivot_action), __LINE__, __FILE__, __CLASS__);
                }
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a User is being created
        User::creating(function (User $user) {
            $time_start = microtime(true);
            // Create a new bridge object
            $bridge = new UserBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                $debug = $bridge->debugging;
                // Pass the user model to creation function
                $bridge->create_update_user($user);
                // Close LDAP connection
                $bridge->demolish();
                if ($debug) Log::debug('LDAP Create User took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to execute.');
            }
        });

        User::updating(function (User $user) {
            $time_start = microtime(true);
            // Create a new bridge object
            $bridge = new UserBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                $debug = $bridge->debugging;
                // Pass the user model to creation function
                $bridge->create_update_user($user);
                // Close LDAP connection
                $bridge->demolish();
                if ($debug) Log::debug('LDAP Create User took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to execute.');
            }
        });

        // While a Role is being created
        Role::creating(function (Role $role) {
            // Create a new bridge object
            $bridge = new Bridge();
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
        Department::creating(function (Department $department) {
            // Create a new bridge object
            $bridge = new Bridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Make a group for that department if needed
                if ($bridge->create_groups && $bridge->departments_are_groups) $bridge->map_group($department->name, 'Departments');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a Course is being created
        Course::creating(function (Course $course) {
            // Create a new bridge object
            $bridge = new Bridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Make a group for that course if needed
                if ($bridge->create_groups && $bridge->courses_are_groups) $bridge->map_group($course->name, 'Courses');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a Campus is being created
        Campus::creating(function (Campus $campus) {
            // Create a new bridge object
            $bridge = new Bridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Make a group for that campus if needed
                if ($bridge->create_groups && $bridge->campuses_are_groups) $bridge->map_group($campus->name, 'Campuses');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a Building is being created
        Building::creating(function (Building $building) {
            // Create a new bridge object
            $bridge = new Bridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Make a group for that building if needed
                if ($bridge->create_groups && $bridge->buildings_are_groups) $bridge->map_group($building->name, 'Buildings');
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a Password is creating
        Password::creating(function (Password $password) {
            // Create a new bridge object
            $bridge = new UserBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Get the user associated with the password
                $user = $password->user;
                // If the user is waiting for their new password, set it.
                if ($user->waiting_for_password) $bridge->set_user_password($user, $password);
                // Close LDAP connection
                $bridge->demolish();
            }
        });

        // While a password is changing
        Password::updating(function (Password $password) {
            // Create a new bridge object
            $bridge = new UserBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // Get the user associated with the password
                $user = $password->user;
                // If the user is waiting for their new password, set it.
                if ($user->waiting_for_password) $bridge->set_user_password($user, $password);
                // Close LDAP connection
                $bridge->demolish();
            }
        });
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
