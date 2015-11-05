<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Building;

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

        // Create an array of buildings
        $buildings = array(
            array(1, '37-1', '37 First Street'),
            array(1, '90-1', '90 1st Street'),
            array(1, '92-1', '92 1st Street'),
            array(1, 'ACKR', 'Ackerman Hall'),
            array(2, 'ACRH', 'Albany Res Hall'),
            array(2, 'ADB', 'Art & Design Bldg.'),
            array(2, 'ADM', 'Administration Bldg'),
            array(1, 'ADMO', 'Admission House'),
            array(1, 'ALUM', 'Alumnae/i House'),
            array(2, 'ARM', 'Armory'),
            array(2, 'ART', 'Graphic Design Building'),
            array(2, 'AXT', 'Health Sciences Building'),
            array(1, 'BUCH', 'Buchman Pavilion'),
            array(1, 'BUSH', 'Bush Memorial'),
            array(1, 'CARR', 'Carriage House'),
            array(2, 'CCR', 'Kahl Center'),
            array(1, 'COWE', 'Cowee Hall'),
            array(1, 'DAYC', 'Day Care Center'),
            array(1, 'DINH', 'Dining Hall'),
            array(1, 'EDUC', 'Education Building'),
            array(1, 'FR', 'French House'),
            array(1, 'FREN', 'French House Annex'),
            array(1, 'FRER', 'Frear House'),
            array(2, 'FRO', 'Froman Hall'),
            array(2, 'GDB', 'Graphic Design Building'),
            array(1, 'GERM', 'Do Not Use'),
            array(1, 'GR', 'German House'),
            array(1, 'GURL', 'Gurley Hall'),
            array(2, 'GYM', 'Gymnasium'),
            array(1, 'HA', 'Hart Hall'),
            array(1, 'HART', 'Hart Hall'),
            array(1, 'HVCC', 'HVCC'),
            array(1, 'JNPA', 'John Paine Building'),
            array(1, 'KELL', 'Do Not Use'),
            array(1, 'KS', 'Kellas-Slocum'),
            array(2, 'LIB', 'Library - 2any'),
            array(1, 'LIBT', 'Library - Troy'),
            array(1, 'MA', 'Manning Hall'),
            array(1, 'MANN', 'Manning'),
            array(1, 'MCKA', 'McKins1 Annex'),
            array(1, 'MEAD', 'James L. Meader Thr'),
            array(1, 'MK', 'McKins1'),
            array(1, 'MS', 'McMurray/Spicer/Gale'),
            array(1, 'MSG', 'Do Not Use'),
            array(1, 'NEFF', 'Neff Athletic Center'),
            array(2, 'OPA', 'Opalka Gallery'),
            array(1, 'PLUM', 'Plum Building'),
            array(1, 'RI', 'Ricketts Hall'),
            array(1, 'RICK', 'Ricketts Hall'),
            array(1, 'ROBC', 'Robison Center'),
            array(1, 'ROYC', 'Roy Court'),
            array(2, 'RTH', 'Rathbone Hall'),
            array(1, 'SA', 'Sage Hall'),
            array(1, 'SAGE', 'Do Not Use'),
            array(2, 'SCE', 'Science Building'),
            array(1, 'SCIH', 'Science Hall'),
            array(1, 'SFAC', 'Schacht Fine Arts Cn'),
            array(2, 'SHAL', 'South Hall'),
            array(1, 'SL', 'Slocum Hall'),
            array(1, 'SLC', 'Shea Learning Center'),
            array(1, 'SP', 'Spanish House'),
            array(1, 'SPAN', 'Spanish House'),
            array(1, 'TNIS', 'Tennis Courts'),
            array(2, 'UHA', 'Uh College Suites'),
            array(2, 'UHRH', 'University Heights Res. Apts.'),
            array(1, 'VAND', 'Vanderheyden Hall'),
            array(1, 'WALK', 'Walker Center'),
            array(1, 'WO', 'Wool House'),
            array(1, 'WOOL', 'Do Not Use'),
            array(2, 'WST', 'West Hall')
        );

        // Loop through the buildings and save them to the database
        foreach ($buildings as $buildingArr) {
            $building = new Building();

            $building->campus_id = $buildingArr[0];
            $building->code = $buildingArr[1];
            $building->name = $buildingArr[2];

            $building->save();
        }

    }
}