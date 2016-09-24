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
            if (strpos($token, 'O') === true) $token = str_replace('O', '0', $token);
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