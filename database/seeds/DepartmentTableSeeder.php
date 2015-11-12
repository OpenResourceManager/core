<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\Type\Department;

/**
 * Created by PhpStorm.
 * User: melon
 * Date: 7/7/15
 * Time: 11:06 AM
 */
class DepartmentTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        // Create an array of departments
        $departments = array(
            array('CEU', 'Continuing Education', true),
            array('HUM', 'Humanities', true),
            array('AMS', 'American Studies', true),
            array('AMS, ENG', 'American Studies, English', true),
            array('BIO', 'Biology', true),
            array('CAT', 'Creat Art in Therapy', true),
            array('CRJ', 'Criminal Justice', true),
            array('CRM', 'Criminal Justice', true),
            array('ENG', 'English', true),
            array('ENG, PSY', 'English, Psychology', true),
            array('ITD', 'Interdisciplinary', true),
            array('HST', 'History', true),
            array('HIS', 'History', true),
            array('GLO', 'Intern\'\'tl Globalization Studie', true),
            array('MAT', 'Mathematics', true),
            array('POL', 'Political Science', true),
            array('PACE', 'Publ Pol, Advoc & Civil Engagt', true),
            array('PSY', 'Psychology', true),
            array('SOC', 'Sociology', true),
            array('THR', 'Theatre', true),
            array('BUS', 'Business', true),
            array('MGT', 'Management', true),
            array('ART', 'Art', true),
            array('GMD', 'Graphic & Media Design', true),
            array('IND', 'Interior Design', true),
            array('PHG', 'Photography', true),
            array('ACC', 'Accounting', true),
            array('ZZZ', 'Miscellaneous', true),
            array('CHM', 'Chemistry', true),
            array('EDU', 'Education', true),
            array('CSI', 'Computer Science', true),
            array('SCI', 'Science', true),
            array('HSC', 'Health Sciences', true),
            array('LAW', 'Law', true),
            array('MAT, CSI', 'Mathematics, Computer Science', true),
            array('NSG', 'Nursing', true),
            array('NTR', 'Nutrition', true),
            array('PSC', 'Political Science', true),
            array('PED', 'Physical Education', true),
            array('ITC', 'Information Technology', true),
            array('HSA', 'Health Services Adm', true),
            array('SCP', 'Professional School Counseling', true),
            array('PTY', 'Physical Therapy', true),
            array('MBA', 'Master Business Adm', true),
            array('OTH', 'Occupational Therapy', true),
            array('PTH', 'Physical Therapy', true)
        );

        // Loop through the array then save the data to the database
        foreach ($departments as $departmentArr) {
            $department = new Department();
            $department->code = $departmentArr[0];
            $department->name = $departmentArr[1];
            $department->academic = $departmentArr[2];
            $department->save();
        }
    }

}