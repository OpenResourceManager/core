<?php namespace App\UUD\LDAP;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 2/25/16
 * Time: 9:04 AM
 */

use App\Model\User;
use App\Model\Role;
use DateTime;
use Illuminate\Support\Facades\Log;

class UserBridge extends Bridge
{


    /**
     * @var bool
     */
    public $user_is_preexisting = false;

    /**
     * @var array
     */
    public $preexisting_user = [];

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
            if (!$bin) return false;
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
            if (!$bin) return false;
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
        // Find an existing user by username
        $username_results = $this->find_user_username($user->username);
        // Find an existing user by user_identifier
        $user_identifier_results = $this->find_user_user_identifier($user->user_identifier);
        //$user_identifier_results = $username_results;
        // If either results returns results the user in question exists
        if ($username_results || $user_identifier_results) $this->user_is_preexisting = true;
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
                $this->preexisting_user[$key] = $value;
            }
        }
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
                if (!$role) $this->perform_ldap_error('Error could not form user DN for user creation/update. An unknown role was requested with an ID of ' . strval($role_id));
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
    public function description_field(User $user)
    {
        $format = 'm/d/Y h:i:s A';
        $dec = 'ID: ' . $user->user_identifier;
        if ($this->user_is_preexisting) {
            $created = $this->convert_ldap_time($this->preexisting_user['whencreated'], $format);
            if (strpos($this->preexisting_user['description'], 'ColleagueID') !== false) {
                $desc_array = explode('Created: ', $this->preexisting_user['description']);
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

    /**
     * @param User $user
     * @param string $dn
     * @return array
     */
    public function form_user_attributes(User $user)
    {
        return [
            'cn' => $this->commonName_field($user),
            'description' => [$this->description_field($user)],
            'displayName' => $this->displayName_field($user),
            'employeeID' => $this->employeeID_field($user),
            'extensionName' => [$this->extensionName_field($user)],
            'givenName' => $this->givenName_field($user),
            'homeDirectory' => $this->homeDirectory_field($user),
            'homeDrive' => $this->homeDrive_field(),
            'mail' => $this->mail_field($user),
            'middleName' => $this->middleName_field($user),
            'name' => $this->name_field($user),
            'objectClass' => $this->objectClass_field(),
            'samAccountName' => $this->sAMAccountName_field($user),
            'sn' => $this->sn_field($user),
            'userPrincipalName' => $this->userPrincipalName_field($user)
        ];
    }

    public function create_user(User $user)
    {
        // Does the user exist?
        $this->check_existing_user($user);
        // Gather the user's attributes
        $attributes = $this->form_user_attributes($user);
        //
        // Die(json_encode($attributes));
        // Does the user exist in LDAP?
        if ($this->user_is_preexisting) {
            // Modify the existing user or error
            try {
                ldap_mod_replace($this->connection, $this->preexisting_user['distinguishedname'], $attributes) or $this->perform_ldap_error();
            } catch (\ErrorException $e) {
                $this->perform_ldap_error();
            } catch (\Exception $e) {
                $this->perform_ldap_error();
            }
        } else {
            // Add the new user or error
            try {
                $attributes['distinguishedName'] = $this->distinguishedName_field($user);
                ldap_add($this->connection, $attributes['distinguishedName'], $attributes) or $this->perform_ldap_error();
            } catch (\ErrorException $e) {
                $this->perform_ldap_error();
            } catch (\Exception $e) {
                $this->perform_ldap_error();
            }
        }
    }

}