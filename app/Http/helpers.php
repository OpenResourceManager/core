<?php

/**
 * @param string $number
 * @param string $country_code
 * @return string
 */

function formatPhoneNumber($number, $country_code = false)
{
    $formatted = "(" . substr($number, 0, 3) . ") " . substr($number, 3, 3) . "-" . substr($number, 6);
    if ($country_code) $formatted = '+' . $country_code . ' ' . $formatted;
    return $formatted;
}

/**
 * @param int $min_length
 * @param int $max_length
 * @return mixed|string
 */
function generateVerificationToken($min_length = 3, $max_length = 6)
{
    do {
        $exists = false;
        $length = (int)rand($min_length, $max_length);
        $token = strtoupper(Illuminate\Support\Str::random($length)); // Generate a token with the chosen length
        if (strpos($token, 'O') !== false) $token = str_replace('O', '0', $token);
        $email_exist = App\Http\Models\Api\Email::where('verification_token', $token)->first(); // Get any emails with that token
        $phone_exists = App\Http\Models\Api\MobilePhone::where('verification_token', $token)->first(); // Get any phones with that token
        if (!empty($email_exist) || !empty($phone_exists)) $exists = true;
    } while ($exists);
    return $token;
}

/**
 * @param $token
 * @return bool
 */
function verifyToken($token)
{
    $email = App\Http\Models\Api\Email::where('verification_token', $token)->first(); // Get any emails with that token
    $phone = App\Http\Models\Api\MobilePhone::where('verification_token', $token)->first(); // Get any phones with that token

    if (!empty($email) && !empty($phone)) {
        abort(500, 'Duplicate Token Exception!');
    } elseif (!empty($email)) {
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