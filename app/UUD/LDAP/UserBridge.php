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
    public function find_username($username = '')
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
                'initials',
                'userAccountControl',
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
     * @param string $identifier
     * @return array|bool
     */
    public function find_identifier($identifier = '')
    {
        if (!empty(trim($identifier))) {
            $filter = '(&(objectClass=top)(objectClass=person)(objectClass=user)(employeeID=' . $identifier . '))';
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
                'initials',
                'userAccountControl',
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
        $username_results = $this->find_username($user->username);
        // Find an existing user by identifier
        $identifier_results = $this->find_identifier($user->identifier);
        //$identifier_results = $username_results;
        // If either results returns results the user in question exists
        if ($username_results || $identifier_results) $this->user_is_preexisting = true;
        // Make sure that only one user was returned
        if ($username_results['count'] > 1) $this->perform_ldap_error('More than one user result was found while searching for username: ' . $user->username, __LINE__, __FILE__, __CLASS__);
        // Make sure that only one user was returned
        if ($identifier_results['count'] > 1) $this->perform_ldap_error('More than one user result was found while searching for identifier: ' . $user->identifier, __LINE__, __FILE__, __CLASS__);
        // Make sure that the results returned from both searches match, if both returned results.
        if (($identifier_results['count'] > 0) && ($username_results['count'] > 0)) {
            // Assign results to local var
            $result_1 = $username_results[0];
            // Assign results to local var
            $result_2 = $identifier_results[0];
            // Verify the the objectGUID values match
            if ($result_1['objectGUID'] !== $result_2['objectGUID']) {
                // If the objectGUID values do not match throw an LDAP error
                $this->perform_ldap_error('objectGUID attribute mis-match! The LDAP bridge cannot reliably determine if the target user only has one account. ' .
                    'Info: Result 1 - (GUID =>' . $result_1['objectGUID'] . ', samaccountname => ' . $result_1['samaccountname'][0] . ', employeeid => ' . $result_1['employeeid'][0] . ')' .
                    'Result 2 - (GUID =>' . $result_2['objectGUID'] . ', samaccountname => ' . $result_2['samaccountname'][0] . ', employeeid => ' . $result_2['employeeid'][0] . ')', __LINE__, __FILE__, __CLASS__);
            }
            // Loop over result array and flatten the array.
            foreach ($result_1 as $key => $value) {
                $value = (is_array($value)) ? $value[0] : $value;
                $this->preexisting_user[$key] = $value;
            }
        }
    }


    public function distinguishedName_parent(User $user)
    {
        $dn = $this->user_ou_dn;
        if ($this->roles_map_to_ou) {
            $role_id = $user->primary_role;
            if (!empty($role_id) && !is_null($role_id)) {
                $role = Role::find($role_id);
                if (!$role) $this->perform_ldap_error('Error could not form user DN for user creation/update. An unknown role was requested with an ID of ' . strval($role_id), __LINE__, __FILE__, __CLASS__);
                $role_cn = $role->name;
            } else {
                $role_cn = 'Default';
            }
            $dn = 'OU=' . $role_cn . ',' . $dn;
            $test = $this->test_ou($dn);
            if (!$test) $this->create_ou($role_cn, $dn);
        }
        return $dn;
    }

    /**
     * @param User $user
     * @return bool|string
     */
    public function distinguishedName_field(User $user)
    {
        $time_start = microtime(true);
        $cn = $this->sAMAccountName_field($user);
        $dn = $this->distinguishedName_parent($user);
        if ($this->debugging) Log::debug('LDAP DN took: ' . ((microtime(true) - $time_start) * 1000) . ' ms to form.');
        return 'CN=' . $cn . ',' . $dn;
    }

    /**
     * @param User $user
     * @return string
     */
    public function commonName_field(User $user)
    {
        return $user->format_full_name();
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
        $dec = 'ID: ' . $user->identifier;
        if ($this->user_is_preexisting) {
            $created = $this->convert_ldap_time($this->preexisting_user['whencreated'], $format);
            if (isset($this->preexisting_user['description']) && !empty($this->preexisting_user['description'])) {
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
        } else {
            $date = new DateTime($user->created_at);
            $created = $date->format($format);
        }
        $updated = date($format);
        $dec = $dec . ', Created: ' . $created . ', Updated: ' . $updated . ' - Managed by UUD LDAP Plugin.';
        return $dec;
    }

    /**
     * @param User $user
     * @return string
     */
    public function displayName_field(User $user)
    {
        return $user->format_full_name();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function employeeID_field(User $user)
    {
        return $user->identifier;
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
        return $user->format_first_name();
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
                $this->perform_ldap_error('LDAP Attribute: ' . $attribute . ' is not a recognized as a valid home drive attribute!', __LINE__, __FILE__, __CLASS__);
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
     * @return string
     */
    public function initials_field(User $user)
    {
        $first = $user->format_first_name();
        $middle = $user->format_middle_name();
        $last = $user->format_last_name();
        $initials = '';
        if (!empty($first)) $initials .= $first[0];
        if (!empty($middle)) $initials .= $middle[0];
        if (!empty($last)) $initials .= $last[0];
        return strtoupper($initials);
    }

    /**
     * @param string $password
     * @return string
     */
    public function unicodePassword_field($password = '')
    {
        $return = '';
        if (empty($password)) $password = str_random(16) . '1!Ab';
        $password = "\"" . $password . "\"";
        for ($i = 0; $i < strlen($password); $i++) {
            $return .= "{$password{$i}}\000";
        }
        return $return;
    }

    /**
     * @param User $user
     * @param string $dn
     * @return array
     */
    public function form_user_attributes(User $user)
    {
        return [
            'description' => [$this->description_field($user)],
            'displayName' => $this->displayName_field($user),
            'employeeID' => $this->employeeID_field($user),
            'extensionName' => [$this->extensionName_field($user)],
            'givenName' => $this->givenName_field($user),
            'homeDirectory' => $this->homeDirectory_field($user),
            'homeDrive' => $this->homeDrive_field(),
            'mail' => $this->mail_field($user),
            'middleName' => $this->middleName_field($user),
            'objectClass' => $this->objectClass_field(),
            'samAccountName' => $this->sAMAccountName_field($user),
            'sn' => $this->sn_field($user),
            'initials' => $this->initials_field($user),
            'UserAccountControl' => '512'
        ];
    }

    /**
     * @param array $attrs
     * @return array
     */
    public function check_attributes($attrs = [])
    {
        foreach ($attrs as $attr => $value) {
            if (empty($value) || is_null($value)) {
                unset($attrs[$attr]);
            }
        }
        return $attrs;
    }

    /**
     * @param User $user
     * @param array $attrs
     */
    public function modify_user(User $user, $attrs = [])
    {
        // Remove attributes that have not changed.
        unset($attrs['objectClass']); // This should never change
        // Go over each attribute
        foreach ($attrs as $attr => $value) {
            // Make sure that the existing user attr exists before we check to see if it was modified. If it does not exists we obviously want to keep it.
            if (isset($this->preexisting_user[strtolower($attr)])) {
                // Are the attributes the same?
                if ($this->preexisting_user[strtolower($attr)] == $value) {
                    // Unset this attribute because it has not changed.
                    unset($attrs[$attr]);
                }
            }
        }
        // Loop Over the attributes and modify them if needed.
        foreach ($attrs as $attr => $value) {
            try {
                // If we are debugging, log some info.
                if ($this->debugging) {
                    // Flatten attributes for logging, if they are arrays
                    if (is_array($attr)) $attr = implode('-', $attr);
                    if (is_array($value)) $value = implode('-', $value);
                    // Log the modify
                    Log::debug('Modify: ' . $attr . ' --> ' . $value);
                }
                // Try to modify the attribute
                ldap_mod_replace($this->connection, $this->preexisting_user['distinguishedname'], [$attr => $value]);
            } catch (\ErrorException $e) {
                // Catch any exceptions so HTML is not returned
                $this->perform_ldap_error(ldap_error($this->connection) . ' ' . $attr . ' => ' . $value, __LINE__, __FILE__, __CLASS__);
            } catch (\Exception $e) {
                // Catch any exceptions so HTML is not returned
                $this->perform_ldap_error(ldap_error($this->connection) . ' ' . $attr . ' => ' . $value, __LINE__, __FILE__, __CLASS__);
            }
        }

        // Gather variables for old CN & DN, and for potentially new info
        $new_dn = $this->distinguishedName_field($user);
        $old_dn = $this->preexisting_user['distinguishedname'];
        $new_cn = $user->format_full_name();
        $old_cn = $this->preexisting_user['cn'];
        // If the user's DN has changed rename the the user.
        if ($new_dn != $old_dn || $new_cn != $old_cn) {
            // If the DN is different and we are debugging log it
            if ($this->debugging && $new_dn != $old_dn) Log::debug('Rename DN: ' . $old_dn . ' --> ' . $new_dn);
            // If the CN is different and we are debugging log it
            if ($this->debugging && $new_cn != $old_cn) Log::debug('Rename CN: ' . $old_cn . ' --> ' . $new_cn);
            // Perform a rename operation
            ldap_rename($this->connection, $old_dn, 'CN=' . $new_cn, $this->distinguishedName_parent($user), true) or $this->perform_ldap_error(ldap_error($this->connection), __LINE__, __FILE__, __CLASS__);
        }
    }

    /**
     * @param User $user
     * @param array $attrs
     */
    public function create_user(User $user, $attrs = [])
    {
        try {
            // Add the user's DN to the attribute array
            $attrs['distinguishedName'] = $this->distinguishedName_field($user);
            // Generate a random unicode password
            $attrs['unicodepwd'] = $this->unicodePassword_field();
            // Add the user account in LDAP
            ldap_add($this->connection, $attrs['distinguishedName'], $attrs) or $this->perform_ldap_error('', __LINE__, __FILE__, __CLASS__);
        } catch (\ErrorException $e) {
            // Catch any exceptions so HTML is not returned
            $this->perform_ldap_error('', __LINE__, __FILE__, __CLASS__);
        } catch (\Exception $e) {
            // Catch any exceptions so HTML is not returned
            $this->perform_ldap_error('', __LINE__, __FILE__, __CLASS__);
        }
    }

    /**
     * @param User $user
     */
    public function create_update_user(User $user)
    {
        // Does the user exist?
        $this->check_existing_user($user);
        // Gather the user's attributes
        $attributes = $this->check_attributes($this->form_user_attributes($user));
        // Does the user exist in LDAP?
        if ($this->user_is_preexisting) {
            // Call the modify user function
            $this->modify_user($user, $attributes);
        } else {
            // Call the create user function
            $this->create_user($user, $attributes);
        }
    }

}