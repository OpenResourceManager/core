<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Models\API\Account;
use App\Http\Models\API\Course;

class DevelopmentAccountCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $accountIds = Account::pluck('id')->all();
        $courseIds = Course::pluck('id')->all();

        foreach (range(1, 51) as $index) {
            $account = Account::find($faker->unique()->randomElement($accountIds));
            $courseId = $faker->randomElement($courseIds);
            // Should broadcast an attachment here for 3rd party connections
            $account->courses()->attach($courseId);
        }
    }
}
