<?php

namespace App\UUD\LDAP\Providers;

use App\Model\Role;
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
        // While a Role is being created
        Role::creating(function ($role) {
            // Create a new bridge object
            $bridge = new LdapBridge();
            // Is the bridge enabled?
            if ($bridge->enabled) {
                // If roles map to an OU then verify that it is created
                if ($bridge->roles_map_to_ou) $bridge->create_ou($role->name);
                // Close LDAP connection
                $bridge->demolish();
            }
        });
        /**
         * @todo Create Groups for Roles/Departments/Campuses/Courses/Buildings if enabled
         * @todo Manage User:creating and User:created methods
         */
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public
    function register()
    {
        //
    }
}
