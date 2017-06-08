<?php

use Illuminate\Database\Seeder;
use App\Http\Models\API\LoadStatus;
use App\Models\Access\Permission\Permission;
use Carbon\Carbon;
use App\Models\History\HistoryType;

class CreateLoadStatusesEntities extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'read-load-statuses',
                'display_name' => 'API: Read Load Statuses'
            ],
            [
                'name' => 'write-load-statuses',
                'display_name' => 'API: Write Load Statuses'
            ]
        ];

        $historyTypes = ['LoadStatus'];

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

        foreach (defaultLoadStatuses() as $ls) {
            LoadStatus::create($ls);
        }

        foreach ($historyTypes as $type) {
            HistoryType::create(['name' => $type]);
        }
    }
}
