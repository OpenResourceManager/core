<?php

use Illuminate\Database\Seeder;
use App\Models\History\HistoryType;
use Carbon\Carbon;
use App\Models\Access\Permission\Permission;

class CreateSchoolEntities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $historyTypes = ['School'];
        $permissions = [
            [
                'name' => 'read-schools',
                'display_name' => 'API: Read Schools'
            ],
            [
                'name' => 'write-schools',
                'display_name' => 'API: Write Schools'
            ]
        ];
        foreach ($historyTypes as $type) {
            HistoryType::create(['name' => $type]);
        }
        $count = Permission::count();
        $count += 1;
        foreach ($permissions as $permission) {
            $permission_model = config('access.permission');
            $p = new $permission_model;
            $p->name = $permission['name'];
            $p->display_name = $permission['display_name'];
            $p->sort = $count;
            $p->created_at = Carbon::now();
            $p->updated_at = Carbon::now();
            $p->save();
            $count++;
        }
    }
}
