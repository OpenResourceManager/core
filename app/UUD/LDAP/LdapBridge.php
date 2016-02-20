<?php namespace App\UUD\LDAP;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 2/15/16
 * Time: 3:21 PM
 */

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LdapBridge extends ApiController
{

    /**
     * @var bool
     */
    public $enabled = false;

    /**
     * @return void
     */
    public function enabled()
    {
        $this->enabled = Config::get('ldap.enable_ldap_bridge');
    }

    /**
     * @var array
     */
    protected $hosts;

    /**
     * @return void
     */
    protected function hosts()
    {
        $this->hosts = Config::get('ldap.ldap_hosts');
    }

    /**
     * @var int
     */
    protected $port;

    /**
     * @return void
     */
    protected function port()
    {
        $this->port = Config::get('ldap.ldap_port');
    }

    /**
     * @var bool
     */
    protected $secure;

    /**
     * @return void
     */
    protected function secure()
    {
        $this->secure = Config::get('ldap.ldap_secure');
    }

    /**
     * @var string
     */
    protected $domain;

    /**
     * @return void
     */
    protected function domain()
    {
        $this->domain = Config::get('ldap.ldap_domain');
    }


    /**
     * @var string
     */
    protected $bind_user;

    /**
     * @return void
     */
    protected function bind_user()
    {
        $this->bind_user = Config::get('ldap.ldap_bind_user');
    }

    /**
     * @var string
     */
    protected $bind_password;

    /**
     * @return void
     */
    protected function bind_password()
    {
        $this->bind_password = Config::get('ldap.ldap_bind_password');
    }

    /**
     * @var string
     */
    public $base_ou_dn;

    /**
     * @return void
     */
    public function base_ou_dn()
    {
        $this->base_ou_dn = Config::get('ldap.ldap_tree_base');
    }

    /**
     * @var string
     */
    public $user_ou_dn;

    /**
     * @return void
     */
    public function user_ou_dn()
    {
        $this->user_ou_dn = Config::get('ldap.base_user_ou_dn');
    }

    /**
     * @var bool
     */
    public $create_users;

    /**
     * @return void
     */
    public function create_users()
    {
        $this->create_users = Config::get('ldap.create_users');
    }

    /**
     * @var bool
     */
    public $delete_users;

    /**
     * @return void
     */
    public function delete_users()
    {
        $this->delete_users = Config::get('ldap.delete_users');
    }

    /**
     * @var bool
     */
    public $roles_map_to_ou;

    /**
     * @return void
     */
    public function roles_map_to_ou()
    {
        $this->roles_map_to_ou = Config::get('ldap.roles_map_to_ou');
    }

    /**
     * @var bool
     */
    public $create_groups;

    /**
     * @return void
     */
    public function create_groups()
    {
        $this->create_groups = Config::get('ldap.create_groups');
    }

    /**
     * @var bool
     */
    public $delete_groups;

    /**
     * @return void
     */
    public function delete_groups()
    {
        $this->delete_groups = Config::get('ldap.delete_groups');
    }

    /**
     * @var string
     */
    public $group_ou_dn;

    /**
     * @return void
     */
    public function group_ou_dn()
    {
        $this->group_ou_dn = Config::get('ldap.base_group_ou_dn');
    }

    /**
     * @var string
     */
    public $group_prefix;

    /**
     * @return void
     */
    public function group_prefix()
    {
        $this->group_prefix = Config::get('ldap.group_prefix');
    }

    /**
     * @var bool
     */
    public $roles_are_groups;

    /**
     * @return void
     */
    public function roles_are_groups()
    {
        $this->roles_are_groups = Config::get('ldap.roles_are_groups');
    }

    /**
     * @var bool
     */
    public $departments_are_groups;

    /**
     * @return void
     */
    public function departments_are_groups()
    {
        $this->departments_are_groups = Config::get('ldap.departments_are_groups');
    }

    /**
     * @var bool
     */
    public $courses_are_groups;

    /**
     * @return void
     */
    public function courses_are_groups()
    {
        $this->courses_are_groups = Config::get('ldap.courses_are_groups');
    }

    /**
     * @var bool
     */
    public $campuses_are_groups;

    /**
     * @return void
     */
    public function campuses_are_groups()
    {
        $this->campuses_are_groups = Config::get('ldap.campuses_are_groups');
    }

    /**
     * @var bool
     */
    public $buildings_are_groups;

    /**
     * @return void
     */
    public function buildings_are_groups()
    {
        $this->buildings_are_groups = Config::get('ldap.buildings_are_groups');
    }

    /**
     * @return void
     */
    private function load_settings()
    {
        $time_start = microtime(true);
        $this->hosts();
        $this->port();
        $this->secure();
        $this->domain();
        $this->bind_user();
        $this->bind_password();
        $this->base_ou_dn();
        $this->user_ou_dn();
        $this->create_users();
        $this->delete_users();
        $this->roles_map_to_ou();
        $this->create_groups();
        $this->delete_groups();
        $this->group_ou_dn();
        $this->group_prefix();
        $this->roles_are_groups();
        $this->departments_are_groups();
        $this->courses_are_groups();
        $this->campuses_are_groups();
        $this->buildings_are_groups();
        Log::debug('LDAP Settings took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to load.');
    }

    /**
     * @var resource
     */
    public $connection;

    /**
     * @return resource
     */
    private function connect()
    {
        $time_start = microtime(true);
        if ($this->enabled) {
            $prefix = ($this->secure) ? 'ldaps://' : 'ldap://';
            foreach ($this->hosts as $host) {
                $this->connection = ldap_connect($prefix . $host, $this->port);
                ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
                $bind = @ldap_bind($this->connection, $this->domain . '\\' . $this->bind_user, $this->bind_password);
                if ($bind) {
                    Log::debug('LDAP Connect took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to establish a connection.');
                    return $this->connection;
                }
            }
            Log::debug('LDAP Connect took: ' . ((microtime(true) - $time_start) * 1000) . ' ms, but failed to establish a connection.');
            $this->perform_ldap_error();
        }
    }

    /**
     * LdapBridge constructor.
     */
    function __construct()
    {
        $time_start1 = microtime(true);
        $this->enabled();
        if ($this->enabled) {
            $this->load_settings();
            $this->connect();
            $time_start2 = microtime(true);
            $this->test_user_ou();
            $this->test_group_ou();
            Log::debug('LDAP OU Tests took: ' . ((microtime(true) - $time_start2) * 1000) . ' ms to verify.');
            Log::debug('LDAP Bridge took: ' . ((microtime(true) - $time_start1) * 1000) . ' ms to construct.');
        }
    }

    /**
     * @return void
     */
    public function demolish()
    {
        if ($this->connection) {
            ldap_unbind($this->connection);
            $this->connection = null;
        }
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
    public function perform_ldap_error($message = '')
    {
        $message = (empty($message)) ? ldap_error($this->connection) : $message;
        Log::error('LDAP Service: ' . $message);
        die($this->respond_internal_error('LDAP Service: ' . $message));
    }

    /**
     * @param $ldap
     * @param $dn
     * @return bool
     */
    public function test_ou($dn)
    {
        $filter = '(&(objectClass=top)(|(objectClass=organizationalUnit)(objectClass=container))(distinguishedName=' . $dn . '))';
        $results = ldap_get_entries($this->connection, ldap_search($this->connection, $this->base_ou_dn, $filter, array('objectGUID')));
        return ($results['count'] > 0) ? true : false;
    }

    /**
     * @return void
     */
    public function test_user_ou()
    {
        if (!$this->test_ou($this->user_ou_dn)) {
            $this->perform_ldap_error('The base OU for users could not be found');
        }
    }

    /**
     * @return void
     */
    public function test_group_ou()
    {
        if (!$this->test_ou($this->group_ou_dn)) {
            $this->perform_ldap_error('The base OU for groups could not be found');
        }
    }
}