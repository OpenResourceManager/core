<?php

use App\Http\Models\API\Country;
use App\Http\Models\API\State;
use App\Http\Models\API\MobileCarrier;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Account;
use App\Http\Models\API\Email;
use App\Http\Models\API\MobilePhone;
use App\Http\Models\API\Address;
use App\Http\Models\API\Campus;
use App\Http\Models\API\Building;
use App\Http\Models\API\Room;
use App\Http\Models\API\Department;
use App\Http\Models\API\Course;
use App\User;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = encrypt($faker->unique()->word),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Country::class, function (Faker\Generator $faker) {
    return $faker->unique()->randomElement(countryList());
});

$factory->define(State::class, function (Faker\Generator $faker) {
    return $faker->unique()->randomElement(stateList());
});

$factory->define(MobileCarrier::class, function (Faker\Generator $faker) {
    return $faker->unique()->randomElement(mobileCarrierList());
});

$factory->define(Duty::class, function (Faker\Generator $faker) {

    $word = $faker->unique()->word;

    return [
        'code' => strtoupper($word),
        'label' => ucfirst($word)
    ];
});

$factory->define(Account::class, function (Faker\Generator $faker) {


    $dutyIds = Duty::pluck('id')->all();
    $ssn = $faker->optional()->numberBetween(1000, 9999);
    $pass = $faker->optional()->password(6);
    $birth_date = $faker->optional()->date('Y-m-d');

    if (!empty($ssn)) $ssn = encrypt($ssn);
    if (!empty($pass)) $pass = encrypt($pass);
    if (!empty($birth_date)) $birth_date = encrypt($birth_date);

    return [
        'identifier' => strval($faker->unique()->randomNumber($nbDigits = 7, $strict = true)),
        'name_prefix' => $faker->optional()->title,
        'name_first' => $faker->firstName,
        'name_middle' => $faker->optional()->firstName,
        'name_last' => $faker->lastName,
        'name_postfix' => $faker->optional()->title,
        'name_phonetic' => $faker->optional()->firstName,
        'username' => $faker->unique()->userName,
        'ssn' => $ssn,
        'password' => $pass,
        'birth_date' => $birth_date,
        'primary_duty' => $faker->randomElement($dutyIds)
    ];
});

$factory->define(Email::class, function (Faker\Generator $faker) {

    $accountIDs = App\Http\Models\API\Account::pluck('id')->all();

    $verified = $faker->boolean(95);
    $verificationToken = ($verified) ? null : generateVerificationToken();

    return [
        'account_id' => $faker->randomElement($accountIDs),
        'address' => $faker->unique()->email,
        'verified' => $verified,
        'verification_token' => $verificationToken
    ];
});

$factory->define(MobilePhone::class, function (Faker\Generator $faker) {

    $accountIDs = Account::pluck('id')->all();
    $carrierIDs = MobileCarrier::pluck('id')->all();
    $verified = $faker->boolean(90);
    $verificationToken = ($verified) ? null : generateVerificationToken();
    $countryCode = ($faker->boolean()) ? 1 : null;

    return [
        'account_id' => $faker->randomElement($accountIDs),
        'number' => $faker->unique()->numberBetween(1111111111, 9999999999),
        'mobile_carrier_id' => $faker->randomElement($carrierIDs),
        'country_code' => $countryCode,
        'verified' => $verified,
        'verification_token' => $verificationToken
    ];

});

$factory->define(Address::class, function (Faker\Generator $faker) {

    $state = $faker->randomElement(State::get()->all());
    $account = $faker->randomElement(Account::get()->all());
    $addressee = $account->format_full_name($faker->boolean());

    return [
        'account_id' => $account->id,
        'addressee' => $addressee,
        'organization' => $faker->optional()->company,
        'line_1' => $faker->address,
        'line_2' => $faker->optional()->word,
        'city' => $faker->city,
        'state_id' => $state->id,
        'zip' => $faker->randomNumber(),
        'country_id' => $state->country_id,
    ];

});

$factory->define(Campus::class, function (Faker\Generator $faker) {

    $city = $faker->unique()->city;
    $num = $faker->unique()->randomDigitNotNull;

    return [
        'code' => strtoupper(trim(substr($city, 0, 3))) . $num,
        'name' => $city
    ];
});

$factory->define(Building::class, function (Faker\Generator $faker) {

    $campusIds = Campus::pluck('id')->all();

    $label = preg_replace('/\s\s+/', ' ', $faker->unique()->randomElement([
        trim($faker->optional()->firstName . ' ' . $faker->unique()->lastName . ' ' . $faker->randomElement(buildingPostfixes())),
        trim($faker->streetName . ' ' . $faker->randomElement(buildingPostfixes())),
        trim($faker->randomElement(directions()) . ' ' . $faker->optional()->lastName . ' ' . $faker->randomElement(buildingPostfixes()))
    ]));

    $num = $faker->unique()->randomNumber($nbDigits = 3);
    $code = strtoupper(trim(substr($label, 0, 3)) . $num);

    return [
        'campus_id' => $faker->randomElement($campusIds),
        'code' => $code,
        'label' => $label
    ];

});

$factory->define(Room::class, function (Faker\Generator $faker) {

    $buildingIds = Building::pluck('id')->all();
    $floorLabels = roomFloorLabels();
    $floorNum = $faker->optional()->numberBetween(1, 4);
    $floorLabel = null;
    if ($floorNum == 1) {
        $floorLabel = $floorLabels[0];
    } elseif ($floorNum == 2) {
        $floorLabel = $floorLabels[1];
    } elseif ($floorNum == 3) {
        $floorLabel = $floorLabels[2];
    } elseif ($floorNum == 4) {
        $floorLabel = $floorLabels[3];
    }

    if (is_null($floorNum)) {
        $roomNum = $faker->numberBetween(100, 599);
    } else {
        $roomNum = $faker->numberBetween(($floorNum * 100), (($floorNum * 100) + 99));
    }

    $codes = array(
        $faker->word,
        $faker->word . (String)$faker->numberBetween(1, 999),
        $faker->word . (String)$faker->numberBetween(1, 999),
        $faker->word . (String)$faker->numberBetween(1, 999)
    );

    return [
        'code' => $faker->unique()->randomElement($codes),
        'building_id' => $faker->randomElement($buildingIds),
        'floor_number' => $floorNum,
        'floor_label' => $floorLabel,
        'room_number' => $roomNum,
        'room_label' => $faker->optional()->word
    ];

});

$factory->define(Department::class, function (Faker\Generator $faker) {

    $labels = [
        $faker->word . ' ' . $faker->word,
        $faker->word . ' ' . $faker->word . $faker->word . ' ' . $faker->word,
        implode(' ', $faker->words) . ' ' . $faker->word,
    ];

    return [
        'academic' => $faker->boolean(40),
        'code' => $faker->unique()->text(7),
        'name' => $faker->unique()->randomElement($labels),
    ];

});

$factory->define(Course::class, function (Faker\Generator $faker) {

    $deptIds = Department::where('academic', true)->pluck('id')->all();

    return [
        'department_id' => $faker->randomElement($deptIds),
        'code' => $faker->unique()->text(7) . $faker->randomNumber(3, true),
        'course_level' => $faker->randomElement([100, 200, 300, 400, 500]),
        'name' => $faker->unique()->word
    ];

});