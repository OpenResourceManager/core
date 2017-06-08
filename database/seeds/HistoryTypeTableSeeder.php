<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\History\HistoryType;

/**
 * Class HistoryTypeTableSeeder
 */
class HistoryTypeTableSeeder extends Seeder
{

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        DB::table('history_types')->truncate();

        $types = [
            'User',
            'Role',
            'Account',
            'Address',
            'Building',
            'Campus',
            'Country',
            'Course',
            'Department',
            'Duty',
            'Email',
            'MobileCarrier',
            'MobilePhone',
            'Room',
            'State',
            'Authentication',
            'Verification',
            'Assignment',
            'AliasAccount'
        ];

        foreach ($types as $type) {
            HistoryType::create(['name' => $type]);
        }

        if (DB::connection()->getDriverName() == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}