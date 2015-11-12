<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Type\Role;
use App\Model\Type\Campus;
use App\Model\Type\Building;
use App\Model\Type\Department;
use App\Model\Type\Course;
use App\Model\Type\Community;
use App\Model\Record\User_Record;
use App\Model\Record\Email_Record;
use App\Model\Record\Phone_Record;
use App\Model\Record\Room_Record;
use App\Model\Record\Department_Record;
use App\Model\Record\API_Key_Record;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Role::truncate();
        Campus::truncate();
        Building::truncate();
        Department::truncate();
        Course::truncate();
        Community::truncate();

        User_Record::truncate();
        Email_Record::truncate();
        Phone_Record::truncate();
        Room_Record::truncate();
        Department_Record::truncate();
        API_Key_Record::truncate();

        $this->call('RoleTableSeeder');
        $this->call('CampusTableSeeder');
        $this->call('BuildingTableSeeder');
        $this->call('DepartmentTableSeeder');
        $this->call('CourseTableSeeder');
        $this->call('CommunityTableSeeder');

        $this->call('UserRecordTableSeeder');
        $this->call('EmailRecordTableSeeder');
        $this->call('PhoneRecordTableSeeder');
        $this->call('RoomRecordTableSeeder');
        $this->call('RoleRecordTableSeeder');
        $this->call('DepartmentRecordTableSeeder');
        $this->call('APIKeyRecordTableSeeder');

        Model::reguard();
    }
}
