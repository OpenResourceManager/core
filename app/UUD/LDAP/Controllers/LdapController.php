<?php namespace App\UUD\LDAP\Controllers;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 2/15/16
 * Time: 3:21 PM
 */


use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LdapController extends ApiController
{
    /**
     * @return mixed
     */
    public function enabled()
    {
        return Config::get('ldap.enable_ldap_bridge');
    }

    /**
     * @return bool|resource
     */
    public function open_ldap()
    {
        $hosts = Config::get('ldap.ldap_hosts');
        $port = Config::get('ldap.ldap_port');
        $secure = Config::get('ldap.ldap_secure');
        $ldap_domain = Config::get('ldap.ldap_domain');
        $ldap_bind_user = Config::get('ldap.ldap_bind_user');
        $ldap_user_password = Config::get('ldap.ldap_bind_password');
        $prefix = ($secure) ? 'ldaps://' : 'ldap://';
        $connection = null;

        foreach ($hosts as $host) {
            $connection = ldap_connect($prefix . $host, $port);
            ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);
            $bind = @ldap_bind($connection, $ldap_domain . '\\' . $ldap_bind_user, $ldap_user_password);
            if ($bind) return array(true, $connection);
        }
        return array(false, $connection);
    }

    /**
     * @param $ldap
     */
    public function close_ldap($ldap)
    {
        ldap_unbind($ldap);
    }

    /**
     * @param string $message
     * @return string
     */
    public function respond_internal_error($message)
    {
        header('Content-Type:application/json', true, 500);

        if (!is_array($message)) $message = [$message];

        return json_encode([
            'success' => false,
            'status_code' => 500,
            'error' => $message
        ]);
    }

    /**
     * @param $ldap
     */
    public function perform_ldap_error($ldap, $message = '')
    {
        $message = (empty($message)) ? ldap_error($ldap) : $message;
        Log::error('LDAP Service: ' . $message);
        die($this->respond_internal_error('LDAP Service: ' . $message));
    }

    /**
     * @param $ldap
     * @param $dn
     * @return bool
     */
    public function test_ou($ldap, $dn)
    {
        $filter = '(&(objectClass=top)(|(objectClass=organizationalUnit)(objectClass=container))(distinguishedName=' . $dn . '))';
        $results = ldap_get_entries($ldap, ldap_search($ldap, Config::get('ldap.ldap_tree_base'), $filter, array('objectGUID')));
        return ($results['count'] > 0) ? true : false;
    }

    /**
     * @param $ldap
     * @return object
     */
    public function get_user_ou($ldap)
    {
        $dn = Config::get('ldap.base_user_ou_dn');
        $exists = $this->test_ou($ldap, $dn);
        $message = $exists ? 'The base OU for users exists' : 'The base OU for users could not be found';
        return (object)array('exists' => $exists, 'message' => $message, 'dn' => $dn);
    }

    /**
     * @param $ldap
     * @return object
     */
    public function get_group_ou($ldap)
    {
        $dn = Config::get('ldap.base_group_ou_dn');
        $exists = $this->test_ou($ldap, $dn);
        $message = $exists ? 'The base OU for groups exists' : 'The base OU for groups could not be found';
        return (object)array('exists' => $exists, 'message' => $message, 'dn' => $dn);
    }
}