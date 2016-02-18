<?php

namespace App\UUD\LDAP\Providers;

use App\UUD\LDAP\Controllers\LdapController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class LdapServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $bridge = new LdapController();
        if ($bridge->enabled()) {
            // Open an LDAP connection
            $ldap = $bridge->open_ldap();
            if (!$ldap->started) $bridge->perform_ldap_error($ldap->connection);
            // Verify that the base OU for users exists
            $user_ou = $bridge->get_user_ou($ldap->connection);
            if (!$user_ou->exists) $bridge->perform_ldap_error($ldap->connection, $user_ou->message);
            // Verify that the base OU for groups exists
            $group_ou = $bridge->get_group_ou($ldap->connection);
            if (!$group_ou->exists) $bridge->perform_ldap_error($ldap->connection, $group_ou->message);
            /**
             * @todo Create Role Organizational Units below the base User OU, if enabled
             * @todo Create Groups for Roles/Departments/Campuses/Courses/Buildings if enabled
             * @todo Manage User:creating and User:created methods
             */
            // Close LDAP connection
            $bridge->close_ldap($ldap->connection);
        } else {
            Log::info('LDAP Service: Not enabled, edit Config\\LDAP.php to enable the LDAP service.');
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
