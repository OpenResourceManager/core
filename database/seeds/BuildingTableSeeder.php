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

        $campusIds = Campus::get()->lists('id')->all();

        $buildingPostfixes = [
            'Center',
            'Hall',
            'House',
            'Building',
            'Court',
            'Annex',
            'Pavilion',
        ];

        $directions = [
            'North',
            'South',
            'East',
            'West',
        ];

        foreach (range(1, 1000) as $index) {
            $name = preg_replace('/\s\s+/', ' ', $faker->unique()->randomElement([
                trim($faker->optional()->firstName . ' ' . $faker->unique()->lastName . ' ' . $faker->randomElement($buildingPostfixes)),
                trim($faker->streetName . ' ' . $faker->randomElement($buildingPostfixes)),
                trim($faker->randomElement($directions) . ' ' . $faker->optional()->lastName . ' ' . $faker->randomElement($buildingPostfixes))
            ]));
            $num = $faker->unique()->randomNumber($nbDigits = 3);
            $code = strtoupper(trim(substr($name, 0, 3)) . $num);
            Building::create([
                'campus_id' => $faker->randomElement($campusIds),
                'code' => $code,
                'name' => $name
            ]);
        }
    }
}
