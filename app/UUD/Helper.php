<?php
/**
 * Created by PhpStorm.
 * User: melon
 * Date: 9/19/16
 * Time: 10:38 AM
 */

namespace App\UUD;

use App\Model\Email;
use App\Model\Phone;
use Illuminate\Support\Str;


class Helper
{

    /**
     * @return string
     */
    public static function generateVerificationToken()
    {
        do {
            $exists = false;
            // Pick a token length between 3 and 6
            $length = (int)rand(3, 6);
            $token = strtoupper(Str::random($length)); // Generate a token with the chosen length
            if (strpos($token, 'O') !== false) $token = str_replace('O', '0', $token);
            $email_exist = Email::where('verification_token', $token)->first(); // Get any emails with that token
            $phone_exists = Phone::where('verification_token', $token)->first(); // Get any phones with that token
            if (!empty($email_exist) || !empty($phone_exists)) $exists = true;
        } while ($exists);
        return $token;
    }

    /**
     * @param $token
     * @return bool
     */
    public static function verifyToken($token)
    {
        $email = Email::where('verification_token', $token)->first(); // Get any emails with that token
        $phone = Phone::where('verification_token', $token)->first(); // Get any phones with that token

        if (!empty($email)) {
            $email->verification_token = null;
            $email->verified = true;
            $email->save();
            return $email;
        } elseif (!empty($phone)) {
            $phone->verification_token = null;
            $phone->verified = true;
            $phone->save();
            return $phone;
        } else {
            return false;
        }
    }

    /**
     * @param string $number
     * @param string $country_code
     * @return string
     */
    public static function format_phone_number($number, $country_code = false)
    {
        $formatted = "(" . substr($number, 0, 3) . ") " . substr($number, 3, 3) . "-" . substr($number, 6);
        if ($country_code) $formatted = '+' . $country_code . ' ' . $formatted;
        return $formatted;
    }
}