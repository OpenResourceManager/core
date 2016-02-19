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

    public function enabled()
    {
        $this->enabled = Config::get('ldap.enable_ldap_bridge');
    }

    /**
     * @var array
     */
    protected $hosts;

    protected function hosts()
    {
        $this->hosts = Config::get('ldap.ldap_hosts');
    }

    /**
     * @var int
     */
    protected $port;

    protected function port()
    {
        $this->port = Config::get('ldap.ldap_port');
    }

    /**
     * @var bool
     */
    protected $secure;

    protected function secure()
    {
        $this->secure = Config::get('ldap.ldap_secure');
    }

    /**
     * @var string
     */
    protected $domain;

    protected function domain()
    {
        $this->domain = Config::get('ldap.ldap_domain');
    }


    /**
     * @var string
     */
    protected $bind_user;

    protected function bind_user()
    {
        $this->bind_user = Config::get('ldap.ldap_bind_user');
    }

    /**
     * @var string
     */
    protected $bind_password;

    protected function bind_password()
    {
        $this->bind_password = Config::get('ldap.ldap_bind_password');
    }

    /**
     * @var string
     */
    public $base_ou_dn;

    public function base_ou_dn()
    {
        $this->base_ou_dn = Config::get('ldap.ldap_tree_base');
    }

    /**
     * @var string
     */
    public $user_ou_dn;

    public function user_ou_dn()
    {
        $this->user_ou_dn = Config::get('ldap.base_user_ou_dn');
    }

    /**
     * @var string
     */
    public $group_ou_dn;

    public function group_ou_dn()
    {
        $this->group_ou_dn = Config::get('ldap.base_group_ou_dn');
    }

    /**
     * @var resource
     */
    public $connection;

    private function connect()
    {
        if ($this->enabled) {
            $prefix = ($this->secure) ? 'ldaps://' : 'ldap://';
            foreach ($this->hosts as $host) {
                $this->connection = ldap_connect($prefix . $host, $this->port);
                ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
                ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
                $bind = @ldap_bind($this->connection, $this->domain . '\\' . $this->bind_user, $this->bind_password);
                if ($bind) return $this->connection;
            }
            $this->perform_ldap_error();
        }
    }

    /**
     * LdapController constructor.
     */
    function __construct()
    {
        $this->enabled();
        if ($this->enabled) {
            $this->hosts();
            $this->port();
            $this->secure();
            $this->domain();
            $this->bind_user();
            $this->bind_password();
            $this->base_ou_dn();
            $this->user_ou_dn();
            $this->group_ou_dn();
            $this->connect();
            $this->test_user_ou();
            $this->test_group_ou();
        }
    }


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

    public function test_user_ou()
    {
        if (!$this->test_ou($this->user_ou_dn)) {
            $this->perform_ldap_error('The base OU for users could not be found');
        }
    }

    public function test_group_ou()
    {
        if (!$this->test_ou($this->group_ou_dn)) {
            $this->perform_ldap_error('The base OU for groups could not be found');
        }
    }
}