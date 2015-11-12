<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Building;
use App\Model\Campus;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 10:53 AM
 */
class BuildingTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $faker = Faker::create();

        $campusIds = Campus::get()->lists('id');

        $buildingPostfixes = [
            'Center',
            'Hall',
            'House',
            'Building',
            'Court',
            'Annex',
            'Pavilion',
            ''
        ];

        foreach (range(1, 100) as $index) {
            $bname1 = $faker->optional()->firstName;
            $bname2 = $faker->unique()->lastName;
            $bname3 = $faker->optional()->randomElement($buildingPostfixes);
            $num = $faker->unique()->randomNumber($nbDigits = 3);
            $name = trim($bname1 . ' ' . $bname2 . ' ' . $bname3);
            $code = strtoupper(trim(substr($name, 0, 3)) . $num);
            Building::create([
                'campus_id' => $faker->randomElement($campusIds),
                'code' => $code,
                'name' => $name
            ]);
        }

    }
}