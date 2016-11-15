<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Department;

class DevelopmentDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Department::class, 151)->create();
    }
}
