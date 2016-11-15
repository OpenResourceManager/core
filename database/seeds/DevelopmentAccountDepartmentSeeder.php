<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Http\Models\API\Account;
use App\Http\Models\API\Department;

class DevelopmentAccountDepartmentSeeder extends Seeder
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
        $deptIds = Department::pluck('id')->all();

        foreach (range(1, 50) as $index) {
            $account = Account::find($faker->unique()->randomElement($accountIds));
            $deptId = $faker->randomElement($deptIds);
            // Should broadcast an attachment here $deptIds 3rd party connections
            $account->departments()->attach($deptId);
        }
    }
}
