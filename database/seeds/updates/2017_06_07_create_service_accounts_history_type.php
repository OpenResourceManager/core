<?php

use Illuminate\Database\Seeder;
use App\Models\History\HistoryType;

class CreateServiceAccountHistoryTypes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $historyTypes = ['ServiceAccount'];
        foreach ($historyTypes as $type) {
            HistoryType::create(['name' => $type]);
        }
    }
}
