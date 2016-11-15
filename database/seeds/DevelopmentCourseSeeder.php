<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\Course;

class DevelopmentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Course::class, 251)->create();
    }
}
