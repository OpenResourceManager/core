<?php

namespace App\UUD\LDAP\Providers;

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
        // Instantiate a new ldap bridge
        $bridge = new LdapBridge();
        // Is the bridge enabled?
        if ($bridge->enabled) {
            /**
             * @todo Create Role Organizational Units below the base User OU, if enabled
             * @todo Create Groups for Roles/Departments/Campuses/Courses/Buildings if enabled
             * @todo Manage User:creating and User:created methods
             */
            // Close LDAP connection
            $bridge->demolish();
        }
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
