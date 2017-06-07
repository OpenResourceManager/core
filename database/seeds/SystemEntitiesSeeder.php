<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Country;
use App\Http\Models\API\State;
use App\Http\Models\API\MobileCarrier;

use Illuminate\Database\Eloquent\Model;
use Krucas\Settings\Facades\Settings;


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


        Country::insert(countryList());
        State::insert(stateList());
        MobileCarrier::insert(mobileCarrierList());

        foreach (defaultDuties() as $duty) {
            Duty::create($duty);
        }

        $this->call(CreateLoadStatusesEntities::class);

        Settings::set('enable-registration', false);
        Settings::set('excluded-email-domains', []);
        Settings::set('asset-verification-server-url', '');
        Settings::set('confirmation-from-address', '');
        Settings::set('logo-url', '');
        Settings::set('broadcast-events', false);

        ###################################################################
        #                                                                 #
        #                       LDAP Settings                             #
        #                                                                 #
        ###################################################################

        /**
         * If this is set to false, the LDAP bridge service is disabled.
         */
        Settings::set('ldap-enabled', false);
        /**
         * This is an array of ldap hosts
         */
        Settings::set('ldap-hosts', []);
        /**
         * The short domain name of your ldap domain
         * Example: domain
         */
        Settings::set('ldap-domain', '');
        /**
         * The samAccountName that will be used to bind with LDAP.
         * Example: 'BindUserName'
         */
        Settings::set('ldap-bind-user', '');
        /**
         * The password that belongs to the bind DN.
         */
        Settings::set('ldap-bind-password', '');
        /**
         * Ldap The base of the LDAP tree.
         * Example: OU=UUD,DC=DOMAIN,DC=TLD
         * Example: DC=DOMAIN,DC=TLD
         */
        Settings::set('ldap-tree-base', '');
        /**
         * The base OU that users should reside in.
         * Example: 'OU=Users,DC=DOMAIN,DC=TLD'
         */
        Settings::set('ldap-base-user-dn', '');
        /**
         * Should the bridge delete users in LDAP?
         * If this is set to false, users will be disabled instead of deleted.
         */
        Settings::set('ldap-delete-users', false);
        /**
         * This will place users in an OU based on their primary role.
         * Example: 'CN=User,OU=Role,OU=Users,DC=DOMAIN,DC=TLD'
         */
        Settings::set('ldap-duties-map-to-ou', true);
        /**
         * This is the user's home drive letter.
         * This can be lowercase or uppercase, it is always cast to uppercase.
         */
        Settings::set('ldap-home-drive-letter', '');
        /**
         * This is the path to the homes share for users.
         * Between percent signs place a valid LDAP user attribute that home shares are name after.
         * Example: \\\\fs.domain.tld\\homes\\%sAMAccountName%
         * Example: \\\\fs.domain.tld\\homes\\%employeeID%
         * Example: \\\\fs.domain.tld\\homes\\%sAMAccountName%\\files
         */
        Settings::set('ldap-home-drive-path-pattern', '');
        /**
         * The user's email domain
         */
        Settings::set('ldap-email-domain', '');
        /**
         * This is the ou where groups will reside.
         * Example: OU=Groups,DC=DOMAIN,DC=TLD
         */
        Settings::set('ldap-base-group-dn', '');
        Model::reguard();
    }
}
