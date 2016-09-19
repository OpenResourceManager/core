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
            $length_arr = range(3, 6);
            $rand_keys = array_rand($length_arr, 1);
            $token = strtoupper(Str::quickRandom($length_arr[$rand_keys[0]])); // Generate a token with the chosen length
            $email_exist = Email::where('verification_token', $token)->first();
            $phone_exists = Phone::where('verification_token', $token)->first();
            if (!empty($email_exist) || !empty($phone_exists)) $exists = true;
        } while ($exists);
        return $token;
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