<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 2/15/16
 * Time: 8:09 AM
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
     * The port to communicate with ldap on
     * Example: 389
     * Example: 636
     */
    'ldap_port'                 => 636,
    /**
     * Should ldap over ssl/tls be used?
     */
    'secure_ldap'               => true,
    /**
     * The user DN to that will be used to bind with LDAP.
     * Example: 'CN=UUD,OU=Users,DC=DOMAIN,DC=TLD'
     */
    'bind_user_dn'              => 'CN=UUD,OU=Users,DC=DOMAIN,DC=TLD',
    /**
     * The password that belongs to the bind DN.
     */
    'bind_user_password'        => 'SecretPassword',

    ###################################################################
    #                                                                 #
    #                         User Settings                           #
    #                                                                 #
    ###################################################################
    /**
     * The base OU that users should reside in.
     * Example: 'OU=Users,DC=DOMAIN,DC=TLD'
     */
    'base_user_ou'              => 'OU=Users,DC=DOMAIN,DC=TLD',
    /**
     * Should the bridge create users in LDAP?
     */
    'create_users'              => false,
    /**
     * Should the bridge delete users in LDAP?
     */
    'delete_users'              => false,
    /**
     * This will place users in an OU based on their primary role.
     * Example: 'CN=User,OU=Role,OU=Users,DC=DOMAIN,DC=TLD'
     */
    'roles_map_to_ou'           => false,

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
    'base_group_ou'             => 'OU=Groups,DC=DOMAIN,DC=TLD',
    /**
     * This prefix is put on all groups that UUD creates.
     * Example: uud
     */
    'group_prefix'              => 'uud',
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
];