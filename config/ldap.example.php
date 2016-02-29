<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 2/15/16
 * Time: 8:09 AM
 *
 * To begin copy this file to a new file called `ldap.php` and make sure it is in the config directory.
 *
 */

return [
    ###################################################################
    #                                                                 #
    #                       General Settings                          #
    #                                                                 #
    ###################################################################
    /**
     * If this is set to false, the LDAP bridge service is disabled.
     */
    'enable_ldap_bridge'        => false,
    /**
     * This is an array of ldap hosts
     */
    'ldap_hosts'                => ['ldap-dc1.domain.tld', 'ldap-dc2.domain.tld'],
    /**
     * The short domain name of your ldap domain
     * Example: domain
     */
    'ldap_domain'               => 'domain',
    /**
     * The port to use for ldap
     * Example: 389
     * Example: 636
     */
    'ldap_port'                 => 389,
    /**
     * Connect to ldap using ssl?
     */
    'ldap_secure'               => false,
    /**
     * The samAccountName that will be used to bind with LDAP.
     * Example: 'BindUserName'
     */
    'ldap_bind_user'            => 'BindUserName',
    /**
     * The password that belongs to the bind DN.
     */
    'ldap_bind_password'        => 'SecretPassword',
    /**
     * Ldap The base of the LDAP tree.
     * Example: OU=UUD,DC=DOMAIN,DC=TLD
     * Example: DC=DOMAIN,DC=TLD
     */
    'ldap_tree_base'            => 'DC=DOMAIN,DC=TLD',

    ###################################################################
    #                                                                 #
    #                         User Settings                           #
    #                                                                 #
    ###################################################################
    /**
     * The base OU that users should reside in.
     * Example: 'OU=Users,DC=DOMAIN,DC=TLD'
     */
    'base_user_ou_dn'           => 'OU=Users,OU=UUD,DC=DOMAIN,DC=TLD',
    /**
     * Should the bridge create users in LDAP?
     */
    'create_users'              => false,
    /**
     * Should the bridge delete users in LDAP?
     * If this is set to false, users will be disabled instead of deleted.
     */
    'delete_users'              => false,
    /**
     * This will place users in an OU based on their primary role.
     * Example: 'CN=User,OU=Role,OU=Users,DC=DOMAIN,DC=TLD'
     */
    'roles_map_to_ou'           => false,

    /**
     * This is the user's home drive letter.
     * This can be lowercase or uppercase, it is always cast to uppercase.
     */
    'home_drive_letter'         => 'h',
    /**
     * This is the path to the homes share for users.
     * Between percent signs place a valid LDAP user attribute that home shares are name after.
     * Example: \\\\fs.domain.tld\\homes\\%sAMAccountName%
     * Example: \\\\fs.domain.tld\\homes\\%employeeID%
     * Example: \\\\fs.domain.tld\\homes\\%sAMAccountName%\\files
     */
    'home_drive_path'           => '\\\\fs.domain.tld\\homes\\%LDAP_Attribute%',
    /**
     * The user's email domain
     */
    'email_domain'              => 'domain.tld',

    ###################################################################
    #                                                                 #
    #                        Group Settings                           #
    #                                                                 #
    ###################################################################
    /**
     * Should the bridge, create LDAP groups?
     */
    'create_groups'             => false,
    /**
     * Should the bridge, delete LDAP groups?
     */
    'delete_groups'             => false,
    /**
     * This is the ou where groups will reside.
     * Example: OU=Groups,DC=DOMAIN,DC=TLD
     */
    'base_group_ou_dn'          => 'OU=Groups,OU=UUD,DC=DOMAIN,DC=TLD',
    /**
     * This prefix is put on all groups that UUD creates.
     * Example: uud_
     * Set to null or '' to disable
     */
    'group_prefix'              => 'uud_',
    /**
     * Should the bridge create groups based on roles?
     */
    'roles_are_groups'          => false,
    /**
     * Should the bridge create groups based on departments?
     */
    'departments_are_groups'    => false,
    /**
     * Should the bridge create groups based on courses?
     */
    'courses_are_groups'        => false,
    /**
     * Should the bridge create groups based on campuses?
     */
    'campuses_are_groups'       => false,
    /**
     * Should the bridge create groups based on buildings?
     */
    'buildings_are_groups'      => false,
    /**
     * Enable debug logging. This has the potential to slow things down.
     * This should be set to false on a production environment.
     */
    'debugging'                 => false,
];