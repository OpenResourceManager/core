<?php namespace App\UUD\LDAP;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 2/15/16
 * Time: 3:21 PM
 */

use App\Model\Role;
use App\Model\User;
use DateTime;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class LdapBridge
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
     * @var bool
     */
    public $debugging = false;

    /**
     * @return void
     */
    public function debugging()
    {
        $this->debugging = Config::get('ldap.debugging');
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
     * @var string
     */
    public $home_drive_letter;

    /**
     * @return void
     */
    public function home_drive_letter()
    {
        $this->home_drive_letter = strtoupper(trim(Config::get('ldap.home_drive_letter'))[0]);
    }

    /**
     * @var string
     */
    public $home_drive_path;

    /**
     * @return void
     */
    public function home_drive_path()
    {
        $this->home_drive_path = Config::get('ldap.home_drive_path');
    }

    /**
     * @var string
     */
    public $email_domain;

    /**
     * @return void
     */
    public function email_domain()
    {
        $this->email_domain = strtolower(trim(ltrim(Config::get('ldap.email_domain'), '@')));
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
        $this->home_drive_letter();
        $this->home_drive_path();
        $this->email_domain();
        $this->create_groups();
        $this->delete_groups();
        $this->group_ou_dn();
        $this->group_prefix();
        $this->roles_are_groups();
        $this->departments_are_groups();
        $this->courses_are_groups();
        $this->campuses_are_groups();
        $this->buildings_are_groups();
        $this->debugging();
        if ($this->debugging) Log::debug('LDAP Settings took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to load.');
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
                    if ($this->debugging) Log::debug('LDAP Connect took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to establish a connection.');
                    return $this->connection;
                }
            }
            if ($this->debugging) Log::debug('LDAP Connect took: ' . ((microtime(true) - $time_start) * 1000) . ' ms, but failed to establish a connection.');
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
            if ($this->debugging) Log::debug('LDAP OU Tests took: ' . ((microtime(true) - $time_start2) * 1000) . ' ms to verify.');
            if ($this->debugging) Log::debug('LDAP Bridge took: ' . ((microtime(true) - $time_start1) * 1000) . ' ms to construct.');
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
     * @param string $time
     * @param string $output_format
     * @return bool|string
     */
    public function convert_ldap_time($time, $output_format)
    {
        $ldap = DateTime::createFromFormat('YmdHis', rtrim($time, '.0Z'));
        if (!$ldap) $ldap = DateTime::createFromFormat('Ymdhis', rtrim($time, '.0Z'));
        return ($ldap) ? $ldap->format($output_format) : false;
    }

    /**
     * @param string $dateString
     * @return bool
     */
    public function is_valid_date($dateString)
    {
        return (bool)strtotime($dateString);
    }

    /**
     * @param string $filter
     * @param array $attributes
     * @return array
     */
    public function query_ldap($filter = '', $attributes = array('*'), $binary = false)
    {
        $time_start = microtime(true);
        if ($binary) {
            $search = ldap_search($this->connection, $this->base_ou_dn, $filter);
            $results = ldap_get_values_len($this->connection, ldap_first_entry($this->connection, $search), $attributes);
        } else {
            $search = ldap_search($this->connection, $this->base_ou_dn, $filter, $attributes);
            $results = ldap_get_entries($this->connection, $search);
        }
        if ($this->debugging) Log::debug('LDAP Query took: ' . ((microtime(true) - $time_start) * 1000) . 'ms execute.');
        return $results;
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
     * @param string $message
     * @return void
     */
    public function perform_ldap_error($message = '')
    {
        $message = (empty($message)) ? ldap_error($this->connection) : $message;
        Log::error('LDAP Service: ' . $message);
        die($this->respond_internal_error('LDAP Service: ' . $message));
    }

    /**
     * @param string $dn
     * @return bool
     */
    public function test_ou($dn)
    {
        $time_start = microtime(true);
        $filter = '(&(objectClass=top)(|(objectClass=organizationalUnit)(objectClass=container))(distinguishedName=' . $dn . '))';
        $attributes = array('objectGUID');
        $results = $this->query_ldap($filter, $attributes);
        if ($this->debugging) Log::debug('LDAP OU - ' . $dn . ' - took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to test.');
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

    /**
     * @param string $cn
     * @param string $dn
     * @return void
     */
    public function create_ou($cn, $dn)
    {
        $time_start = microtime(true);
        if (!$this->test_ou($dn)) {
            $new_ou = [
                'objectClass' => ['top', 'organizationalUnit'],
                'distinguishedName' => $dn,
                'ou' => $cn
            ];
            if (!ldap_add($this->connection, $dn, $new_ou)) $this->perform_ldap_error();
            if ($this->debugging) Log::debug('LDAP OU took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to create.');
        }
    }

    /**
     * @param string $cn
     * @return void
     */
    public function map_role_ou($cn)
    {
        $this->create_ou($cn, 'OU=' . $cn . ',' . $this->user_ou_dn);
    }

    /**
     * @param string $dn
     * @return bool
     */
    public function test_group($dn)
    {
        $filter = '(&(objectClass=top)(objectClass=group)(distinguishedName=' . $dn . '))';
        $attributes = array('objectGUID');
        $results = $this->query_ldap($filter, $attributes);
        return ($results['count'] > 0) ? true : false;
    }

    /**
     * @param string $cn
     * @param string $dn
     * @return void
     */
    public function create_group($cn, $dn)
    {
        $time_start = microtime(true);
        if (!$this->test_group($dn)) {
            $new_group = [
                'objectClass' => ['top', 'group'],
                'distinguishedName' => $dn,
                'cn' => $cn,
                'groupType' => -2147483646,
                'name' => $cn,
                'sAMAccountName' => $cn
            ];
            if (!ldap_add($this->connection, $dn, $new_group)) $this->perform_ldap_error();
            if ($this->debugging) Log::debug('LDAP Group took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to create.');
        }
    }

    /**
     * @param string $name
     * @param string $class
     * @return void
     */
    public function map_group($name, $class)
    {
        $cn = (is_null($this->group_prefix) || empty($this->group_prefix)) ? $name : $this->group_prefix . $name;
        $ou_dn = 'OU=' . $class . ',' . $this->group_ou_dn;
        $group_dn = 'CN=' . $cn . ',' . $ou_dn;
        $this->create_ou($class, $ou_dn);
        $this->create_group($cn, $group_dn);
    }

    /**
     * @param string $username
     * @return array|bool
     */
    public function find_user_username($username = '')
    {
        if (!empty(trim($username))) {
            $filter = '(&(objectClass=top)(objectClass=person)(objectClass=user)(sAMAccountName=' . $username . '))';
            $attributes = [
                'cn',
                'distinguishedName',
                'employeeID',
                'description',
                'displayName',
                'extensionName',
                'givenName',
                'homeDirectory',
                'homeDrive',
                'mail',
                'middleName',
                'name',
                'objectCategory',
                'objectClass',
                'primaryGroupID',
                'sAMAccountName',
                'sAMAccountType',
                'sn',
                'telephoneNumber',
                'userPrincipalName',
                'whenCreated',
                'whenChanged',
            ];
            $results = $this->query_ldap($filter, $attributes);
            $bin = $this->query_ldap($filter, 'objectGUID', true);
            $hex = unpack("H*hex", $bin[0]);
            $results[0]['objectGUID'] = $hex['hex'];
            return ($results['count'] > 0) ? $results : false;
        }
        return false;
    }

    /**
     * @param string $user_identifier
     * @return array|bool
     */
    public function find_user_user_identifier($user_identifier = '')
    {
        if (!empty(trim($user_identifier))) {
            $filter = '(&(objectClass=top)(objectClass=person)(objectClass=user)(employeeID=' . $user_identifier . '))';
            $attributes = [
                'cn',
                'distinguishedName',
                'employeeID',
                'description',
                'displayName',
                'extensionName',
                'givenName',
                'homeDirectory',
                'homeDrive',
                'mail',
                'middleName',
                'name',
                'objectCategory',
                'objectClass',
                'primaryGroupID',
                'sAMAccountName',
                'sAMAccountType',
                'sn',
                'telephoneNumber',
                'userPrincipalName',
                'whenCreated',
                'whenChanged',
            ];
            $results = $this->query_ldap($filter, $attributes);
            $bin = $this->query_ldap($filter, 'objectGUID', true);
            $hex = unpack("H*hex", $bin[0]);
            $results[0]['objectGUID'] = $hex['hex'];
            return ($results['count'] > 0) ? $results : false;
        }
        return false;
    }

    /**
     * @param User $user
     * @return array
     */
    public function check_existing_user(User $user)
    {
        // Init exist array
        $exists = array(false, []);
        // Find an existing user by username
        $username_results = $this->find_user_username($user->username);
        // Find an existing user by user_identifier
        $user_identifier_results = $this->find_user_user_identifier($user->user_identifier);
        //$user_identifier_results = $username_results;
        // If either results returns results the user in question exists
        if ($username_results || $user_identifier_results) $exists[0] = true;
        // Make sure that only one user was returned
        if ($username_results['count'] > 1) $this->perform_ldap_error('More than one user result was found while searching for username: ' . $user->username);
        // Make sure that only one user was returned
        if ($user_identifier_results['count'] > 1) $this->perform_ldap_error('More than one user result was found while searching for user_identifier: ' . $user->user_identifier);
        // Make sure that the results returned from both searches match, if both returned results.
        if (($user_identifier_results['count'] > 0) && ($username_results['count'] > 0)) {
            // Assign results to local var
            $result_1 = $username_results[0];
            // Assign results to local var
            $result_2 = $user_identifier_results[0];
            // Verify the the objectGUID values match
            if ($result_1['objectGUID'] !== $result_2['objectGUID']) {
                // If the objectGUID values do not match throw an LDAP error
                $this->perform_ldap_error('objectGUID attribute mis-match! The LDAP bridge cannot reliably determine if the target user only has one account. ' .
                    'Info: Result 1 - (GUID =>' . $result_1['objectGUID'] . ', samaccountname => ' . $result_1['samaccountname'][0] . ', employeeid => ' . $result_1['employeeid'][0] . ')' .
                    'Result 2 - (GUID =>' . $result_2['objectGUID'] . ', samaccountname => ' . $result_2['samaccountname'][0] . ', employeeid => ' . $result_2['employeeid'][0] . ')');
            }
            // Loop over result array and flatten the array.
            foreach ($result_1 as $key => $value) {
                $value = (is_array($value)) ? $value[0] : $value;
                $exists[1][$key] = $value;
            }
        }
        // Return the user info
        return $exists;
    }

    /**
     * @param User $user
     * @return bool|string
     */
    public function distinguishedName_field(User $user)
    {
        $time_start = microtime(true);
        $cn = $user->full_name;
        $dn = $this->user_ou_dn;
        if ($this->roles_map_to_ou) {
            $role_id = $user->primary_role;
            if (!empty($role_id) && !is_null($role_id)) {
                $role = Role::find($role_id);
                if (!$role) $this->perform_ldap_error('Error could not form user DN for user creation/update. An unknown role was requested with an ID of ' . strval($primary_role_id));
                $role_cn = $role->name;
            } else {
                $role_cn = 'Default';
            }
            $dn = 'OU=' . $role_cn . ',' . $dn;
            $test = $this->test_ou($dn);
            if (!$test) $this->create_ou($cn, $dn);
        }
        if ($this->debugging) Log::debug('LDAP DN took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to form.');
        return 'CN=' . $cn . ',' . $dn;
    }

    /**
     * @param User $user
     * @return string
     */
    public function commonName_field(User $user)
    {
        return $user->full_name;
    }

    /**
     * @param User $user
     * @return string
     */
    public function mail_field(User $user)
    {
        return trim(strtolower($user->username . '@' . $this->email_domain));
    }

    /**
     * @param User $user
     * @return string
     */
    public function sAMAccountName_field(User $user)
    {
        return trim(strtolower($user->username));
    }

    /**
     * @return array
     */
    public function objectClass_field()
    {
        return ['top', 'organizationalPerson', 'person', 'user'];
    }

    /**
     * @param User $user
     * @param bool $existed
     * @param array $existing_info
     * @return string
     */
    public function description_field(User $user, $existed = false, $existing_info = [])
    {
        $format = 'm/d/Y h:i:s A';
        $dec = 'ID: ' . $user->user_identifier;
        if ($existed) {
            $created = $this->convert_ldap_time($existing_info['whencreated'], $format);
            if (strpos($existing_info['description'], 'ColleagueID') !== false) {
                $desc_array = explode('Created: ', $existing_info['description']);
                $original_date = trim($desc_array[1]);
                if ($this->is_valid_date($original_date)) {
                    $date = new DateTime($original_date);
                    $created = $date->format($format);
                }
            } else {
                $date = new DateTime($user->created_at);
                $created = $date->format($format);
            }
        } else {
            $date = new DateTime($user->created_at);
            $created = $date->format($format);
        }
        $date = new DateTime($user->updated_at);
        $updated = $date->format($format);
        $dec = $dec . ', Created: ' . $created . ', Updated: ' . $updated . ' - Managed by UUD LDAP Plugin.';
        return $dec;
    }

    /**
     * @param User $user
     * @return string
     */
    public function displayName_field(User $user)
    {
        return $user->full_name;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function employeeID_field(User $user)
    {
        return $user->user_identifier;
    }

    /**
     * @param User $user
     * @return string
     */
    public function extensionName_field(User $user)
    {
        $name = $user->format_last_name() . ', ' . $user->format_first_name();
        $middle = $user->format_middle_name();
        if (!empty($middle)) $name = $name . ' ' . $middle;
        return $name;
    }

    /**
     * @param User $user
     * @return string
     */
    public function givenName_field(User $user)
    {
        return $user->format_last_name();
    }

    /**
     * @param User $user
     * @return string
     */
    public function homeDirectory_field(User $user)
    {
        $raw_path = $this->home_drive_path;
        $path_arr = explode('%', $raw_path);
        $attribute = strtolower($path_arr[1]);
        switch ($attribute) {
            case 'samaccountname' :
                $path = $path_arr[0] . $this->sAMAccountName_field($user);
                if (!empty($path_arr[2]) && isset($path_arr[2])) $path = $path . $path_arr[2];
                return $path;
                break;
            case 'employeeid' :
                $path = $path_arr[0] . $this->employeeID_field($user);
                if (!empty($path_arr[2]) && isset($path_arr[2])) $path = $path . $path_arr[2];
                return $path;
                break;
            default:
                $this->perform_ldap_error('LDAP Attribute: ' . $attribute . ' is not a recognized as a valid home drive attribute!');
        }

    }

    /**
     * @return string
     */
    public function homeDrive_field()
    {
        return $this->home_drive_letter . ':';
    }

    /**
     * @param User $user
     * @return string
     */
    public function middleName_field(User $user)
    {
        return $user->format_middle_name();
    }

    /**
     * @param User $user
     * @return string
     */
    public function name_field(User $user)
    {
        return $user->full_name;
    }

    /**
     * @param User $user
     * @return string
     */
    public function sn_field(User $user)
    {
        return $user->format_last_name();
    }

    /**
     * @param User $user
     * @return string
     */
    public function userPrincipalName_field(User $user)
    {
        return trim(strtolower($user->username . '@' . $this->email_domain));
    }

    public function create_user(User $user)
    {
        // Check to see if we have a user in LDAP with this info
        $user_test_results = $this->check_existing_user($user);
        $user_existed_in_ldap = $user_test_results[0];
        $existing_ldap_info = $user_test_results[1];
        // Gather properties of LDAP user
        $commonName = $this->commonName_field($user);
        $description = $this->description_field($user, $user_existed_in_ldap, $existing_ldap_info);
        $displayName = $this->displayName_field($user);
        $distinguishedName = $this->distinguishedName_field($user);
        $employeeID = $this->employeeID_field($user);
        $extensionName = $this->extensionName_field($user);
        $givenName = $this->givenName_field($user);
        $homeDirectory = $this->homeDirectory_field($user);
        $homeDrive = $this->homeDrive_field();
        $mail = $this->mail_field($user);
        $middleName = $this->middleName_field($user);
        $name = $this->name_field($user);
        $objectClass = $this->objectClass_field();
        $samAccountName = $this->sAMAccountName_field($user);
        $sn = $this->sn_field($user);
        $userPrincipalName = $this->userPrincipalName_field($user);
        // Die here, for testing
        //Die($homeDrive);
    }
}