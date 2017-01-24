<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Krucas\Settings\Facades\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{

    /**
     * @return View
     */
    public function getSettings()
    {
        $allow_reg = Settings::get('enable-registration', false);
        $checked_allow_reg = ($allow_reg) ? 'checked' : '';

        $email_blacklist = join(',', Settings::get('excluded-email-domains', []));

        $bc_events = Settings::get('broadcast-events', false);
        $bc_events_checked = ($bc_events) ? 'checked' : '';

        $asset_verification_server_url = Settings::get('asset-verification-server-url', '');

        $ldap_enabled = Settings::get('ldap-enabled', false);
        $checked_enable_ldap = ($ldap_enabled) ? 'checked' : '';
        $ldap_hosts = join(',', Settings::get('ldap-hosts', []));
        $ldap_bind_user = Settings::get('ldap-bind-user', '');
        $ldap_bind_password = Settings::get('ldap-bind-password', '');
        $ldap_tree_base = Settings::get('ldap-tree-base', '');
        $ldap_base_user_dn = Settings::get('ldap-base-user-dn', '');
        $ldap_base_group_dn = Settings::get('ldap-base-group-dn', '');
        $ldap_delete_users = Settings::get('ldap-delete-users', false);
        $checked_delete_users = ($ldap_delete_users) ? 'checked' : '';
        $ldap_duties_map_to_ou = Settings::get('ldap-duties-map-to-ou', true);
        $checked_duties_map_to_ou = ($ldap_duties_map_to_ou) ? 'checked' : '';
        $ldap_home_drive_letter = Settings::get('ldap-home-drive-letter', '');
        $ldap_home_drive_path = Settings::get('ldap-home-drive-path-pattern', '');
        $ldap_email_domain = Settings::get('ldap-email-domain', '');

        return view('backend.settings', [
            'allow_reg' => (int)$allow_reg,
            'checked_allow_reg' => $checked_allow_reg,
            'bc_events' => (int)$bc_events,
            'bc_events_checked' => $bc_events_checked,
            'asset_verification_server_url' => $asset_verification_server_url,
            'email_blacklist' => $email_blacklist,
            'ldap_enabled' => $ldap_enabled,
            'checked_enable_ldap' => $checked_enable_ldap,
            'ldap_hosts' => $ldap_hosts,
            'ldap_bind_user' => $ldap_bind_user,
            'ldap_bind_password' => $ldap_bind_password,
            'ldap_tree_base' => $ldap_tree_base,
            'ldap_base_user_dn' => $ldap_base_user_dn,
            'ldap_base_group_dn' => $ldap_base_group_dn,
            'ldap_delete_users' => $ldap_delete_users,
            'checked_delete_users' => $checked_delete_users,
            'ldap_duties_map_to_ou' => $ldap_duties_map_to_ou,
            'checked_duties_map_to_ou' => $checked_duties_map_to_ou,
            'ldap_home_drive_letter' => $ldap_home_drive_letter,
            'ldap_home_drive_path' => $ldap_home_drive_path,
            'ldap_email_domain' => $ldap_email_domain,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveSettings(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'allow_reg' => 'nullable|integer|min:0|max:1',
            'bc_events' => 'nullable|integer|min:0|max:1',
            'email_blacklist' => 'nullable|string',
            'asset_verification_server_url' => 'nullable|url',
            'ldap_enabled' => 'nullable|integer|min:0|max:1',
            'ldap_hosts' => 'required_with:ldap_enabled',
            'ldap_bind_user' => 'required_with:ldap_enabled',
            'ldap_bind_password' => 'required_with:ldap_enabled',
            'ldap_tree_base' => 'required_with:ldap_enabled',
            'ldap_base_user_dn' => 'required_with:ldap_enabled',
            'ldap_delete_users' => 'nullable|integer|min:0|max:1',
            'ldap_duties_map_to_ou' => 'nullable|integer|min:0|max:1',
            'ldap_home_drive_letter' => 'required_with:ldap_enabled',
            'ldap_home_drive_path' => 'required_with:ldap_enabled',
            'ldap_email_domain' => 'required_with:ldap_enabled',
            'ldap_base_group_dn' => 'required_with:ldap_enabled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->exceptInput()->withErrors($validator);
        }

        Settings::set('enable-registration', array_key_exists('allow_reg', $data));
        Settings::set('excluded-email-domains', array_map('trim', explode(',', $data['email_blacklist'])));
        Settings::set('broadcast-events', array_key_exists('bc_events', $data));

        Settings::set('asset-verification-server-url', $data['asset_verification_server_url']);

        /**
         * If this is set to false, the LDAP bridge service is disabled.
         */
        Settings::set('ldap-enabled', array_key_exists('ldap_enabled', $data));
        /**
         * This is an array of ldap hosts
         */
        Settings::set('ldap-hosts', array_map('trim', explode(',', $data['ldap_hosts'])));
        /**
         * The samAccountName that will be used to bind with LDAP.
         * Example: 'BindUserName'
         */
        Settings::set('ldap-bind-user', $data['ldap_bind_user']);
        /**
         * The password that belongs to the bind DN.
         */
        Settings::set('ldap-bind-password', $data['ldap_bind_password']);
        /**
         * Ldap The base of the LDAP tree.
         * Example: OU=UUD,DC=DOMAIN,DC=TLD
         * Example: DC=DOMAIN,DC=TLD
         */
        Settings::set('ldap-tree-base', $data['ldap_tree_base']);
        /**
         * The base OU that users should reside in.
         * Example: 'OU=Users,DC=DOMAIN,DC=TLD'
         */
        Settings::set('ldap-base-user-dn', $data['ldap_base_user_dn']);
        /**
         * Should the bridge delete users in LDAP?
         * If this is set to false, users will be disabled instead of deleted.
         */
        Settings::set('ldap-delete-users', array_key_exists('ldap_delete_users', $data));
        /**
         * This will place users in an OU based on their primary role.
         * Example: 'CN=User,OU=Role,OU=Users,DC=DOMAIN,DC=TLD'
         */
        Settings::set('ldap-duties-map-to-ou', array_key_exists('ldap_duties_map_to_ou', $data));
        /**
         * This is the user's home drive letter.
         * This can be lowercase or uppercase, it is always cast to uppercase.
         */
        Settings::set('ldap-home-drive-letter', $data['ldap_home_drive_letter']);
        /**
         * This is the path to the homes share for users.
         * Between percent signs place a valid LDAP user attribute that home shares are name after.
         * Example: \\\\fs.domain.tld\\homes\\%sAMAccountName%
         * Example: \\\\fs.domain.tld\\homes\\%employeeID%
         * Example: \\\\fs.domain.tld\\homes\\%sAMAccountName%\\files
         */
        Settings::set('ldap-home-drive-path-pattern', $data['ldap_home_drive_path']);
        /**
         * The user's email domain
         */
        Settings::set('ldap-email-domain', $data['ldap_email_domain']);
        /**
         * This is the ou where groups will reside.
         * Example: OU=Groups,DC=DOMAIN,DC=TLD
         */
        Settings::set('ldap-base-group-dn', $data['ldap_base_group_dn']);

        return redirect('/admin/settings');

    }

}
