<?php

use Faker\Generator;
use App\Models\Access\User\User;
use App\Http\Models\API\Country;
use App\Http\Models\API\State;
use App\Http\Models\API\MobileCarrier;
use App\Http\Models\API\Duty;
use App\Http\Models\API\Account;
use App\Http\Models\API\AliasAccount;
use App\Http\Models\API\Email;
use App\Http\Models\API\MobilePhone;
use App\Http\Models\API\Address;
use App\Http\Models\API\Campus;
use App\Http\Models\API\Building;
use App\Http\Models\API\Room;
use App\Http\Models\API\Department;
use App\Http\Models\API\Course;
use App\Http\Models\API\ServiceAccount;
use App\Http\Models\API\LoadStatus;
use App\Http\Models\API\School;

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

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
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
        'code' => str_replace(' ', '-', strtoupper($word)),
        'label' => ucfirst($word)
    ];
});

$factory->define(LoadStatus::class, function (Faker\Generator $faker) {
    $word = $faker->unique()->word;
    return [
        'code' => str_replace(' ', '-', strtoupper($word)),
        'label' => ucfirst($word)
    ];
});

$factory->define(School::class, function (Faker\Generator $faker) {
    $words = $faker->unique()->words;
    return [
        'code' => str_replace(' ', '-', strtoupper($words)),
        'label' => ucfirst($words)
    ];
});

$factory->define(Account::class, function (Faker\Generator $faker) {
    $dutyIds = Duty::pluck('id')->all();
    $loadStatusIds = LoadStatus::pluck('id')->all();
    $loadStatusIds[] = null;
    $ssn = $faker->optional()->numberBetween(1000, 9999);
    $pass = $faker->optional()->password(6);
    $birth_date = $faker->optional()->date('Y-m-d');
    $expires_at = null;
    if ($faker->boolean) {
        $expires_at = $faker->dateTimeBetween('+1 days', '+2 years');
    }
    $disabled = $faker->boolean;
    $should_propagate_password = false;
    if (!empty($ssn)) $ssn = encrypt($ssn);
    if (!empty($pass)) $pass = encrypt($pass);
    if (!empty($pass)) $should_propagate_password = $faker->boolean;
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
        'should_propagate_password' => $should_propagate_password,
        'birth_date' => $birth_date,
        'expires_at' => $expires_at,
        'disabled' => $disabled,
        'primary_duty_id' => $faker->randomElement($dutyIds),
        'load_status_id' => $faker->randomElement($loadStatusIds)
    ];
});

$factory->define(AliasAccount::class, function (Faker\Generator $faker) {
    $accountIds = Account::pluck('id')->all();
    $pass = $faker->optional()->password(6);
    $expires_at = null;
    if (!empty($pass)) $pass = encrypt($pass);

    if ($faker->boolean) {
        $expires_at = $faker->dateTimeBetween('+1 days', '+2 years');
    }

    $disabled = $faker->boolean;
    $should_propagate_password = false;

    return [
        'account_id' => $faker->randomElement($accountIds),
        'username' => $faker->unique()->userName,
        'password' => $pass,
        'should_propagate_password' => $should_propagate_password,
        'expires_at' => $expires_at,
        'disabled' => $disabled
    ];
});

$factory->define(ServiceAccount::class, function (Faker\Generator $faker) {
    $accountIds = Account::pluck('id')->all();
    $pass = $faker->optional()->password(6);
    $expires_at = null;
    if (!empty($pass)) $pass = encrypt($pass);

    if ($faker->boolean) {
        $expires_at = $faker->dateTimeBetween('+1 days', '+2 years');
    }

    $disabled = $faker->boolean;
    $should_propagate_password = false;

    return [
        'account_id' => $faker->randomElement($accountIds),
        'identifier' => strval($faker->unique()->randomNumber($nbDigits = 7, $strict = true)),
        'username' => $faker->unique()->userName,
        'name_first' => $faker->firstName,
        'name_last' => $faker->lastName,
        'password' => $pass,
        'should_propagate_password' => $should_propagate_password,
        'expires_at' => $expires_at,
        'disabled' => $disabled
    ];
});

$factory->define(Email::class, function (Faker\Generator $faker) {

    $accountIDs = App\Http\Models\API\Account::pluck('id')->all();

    $verified = $faker->boolean(95);
    $verificationToken = ($verified) ? null : generateVerificationToken();
    $verification_callback = $faker->randomElement([$faker->url, null]);

    return [
        'account_id' => $faker->randomElement($accountIDs),
        'address' => $faker->unique()->email,
        'verified' => $verified,
        'verification_token' => $verificationToken,
        'verification_callback' => $verification_callback
    ];
});

$factory->define(MobilePhone::class, function (Faker\Generator $faker) {

    $accountIDs = Account::pluck('id')->all();
    $carrierIDs = MobileCarrier::pluck('id')->all();
    $verified = $faker->boolean(90);
    $verificationToken = ($verified) ? null : generateVerificationToken();
    $countryCode = ($faker->boolean()) ? 1 : null;
    $verification_callback = $faker->randomElement([$faker->url, null]);

    return [
        'account_id' => $faker->randomElement($accountIDs),
        'number' => $faker->unique()->numberBetween(1111111111, 9999999999),
        'mobile_carrier_id' => $faker->randomElement($carrierIDs),
        'country_code' => $countryCode,
        'verified' => $verified,
        'verification_token' => $verificationToken,
        'verification_callback' => $verification_callback
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

    $city = ($faker->boolean()) ? $faker->unique()->city : $faker->unique()->word;
    $num = $faker->unique()->numberBetween(1, 99999999);

    return [
        'code' => str_replace(' ', '-', strtoupper(trim($city))) . $num,
        'label' => $city
    ];
});

$factory->define(Building::class, function (Faker\Generator $faker) {

    $campusIds = Campus::pluck('id')->all();

    $label = preg_replace('/\s\s+/', ' ', $faker->randomElement([
        trim($faker->optional()->firstName . ' ' . $faker->lastName . ' ' . $faker->randomElement(buildingPostfixes())),
        trim($faker->streetName . ' ' . $faker->randomElement(buildingPostfixes())),
        trim($faker->randomElement(directions()) . ' ' . $faker->optional()->lastName . ' ' . $faker->randomElement(buildingPostfixes()))
    ]));

    $num = $faker->unique()->numberBetween(1, 99999999);
    $code = str_replace(' ', '-', strtoupper(trim($label) . $num));

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
        str_replace(' ', '-', $faker->word),
        str_replace(' ', '-', $faker->word . (String)$faker->numberBetween(1, 999)),
        str_replace(' ', '-', $faker->word . (String)$faker->numberBetween(1, 999)),
        str_replace(' ', '-', $faker->word . (String)$faker->numberBetween(1, 999))
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
        'code' => str_replace(' ', '-', $faker->unique()->text(7)),
        'label' => $faker->unique()->randomElement($labels),
    ];

});

$factory->define(Course::class, function (Faker\Generator $faker) {

    $deptIds = Department::where('academic', true)->pluck('id')->all();

    $labels = [
        $faker->word . ' ' . $faker->word,
        $faker->word . ' ' . $faker->word . $faker->word . ' ' . $faker->word,
        implode(' ', $faker->words) . ' ' . $faker->word,
    ];

    $label = $faker->unique()->randomElement($labels);
    $level = $faker->randomElement([100, 200, 300, 400, 500]);
    $code = str_replace(' ', '-', $label . $level);

    return [
        'department_id' => $faker->randomElement($deptIds),
        'code' => $code,
        'course_level' => $level,
        'label' => $label
    ];

});