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
            $result = $bridge->open_ldap();
            // Get our LDAP connection
            $ldap_connection = $result[1];
            if (!$result[0]) $bridge->perform_ldap_error($ldap_connection);
            // Verify that the base OU for users exists
            $user_ou = $bridge->get_user_ou($ldap_connection);
            if (!$user_ou->exists) $bridge->perform_ldap_error($ldap_connection, $user_ou->message);
            // Verify that the base OU for groups exists
            $group_ou = $bridge->get_group_ou($ldap_connection);
            if (!$group_ou->exists) $bridge->perform_ldap_error($ldap_connection, $group_ou->message);
            /**
             * @todo Create Role Organizational Units below the base User OU, if enabled
             * @todo Create Groups for Roles/Departments/Campuses/Courses/Buildings if enabled
             * @todo Manage User:creating and User:created methods
             */
            // Close LDAP connection
            $bridge->close_ldap($ldap_connection);
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
