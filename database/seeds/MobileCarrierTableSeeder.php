<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Model\MobileCarrier;

class MobileCarrierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $carriers = [
            ['name' => 'Verizon Wireless', 'code' => 'VZW'],
            ['name' => 'AT&T', 'code' => 'ATT'],
            ['name' => 'T-Mobile', 'code' => 'TMO'],
            ['name' => 'Sprint', 'code' => 'SPR'],
            ['name' => 'U.S Cellular', 'code' => 'USC'],
            ['name' => 'Virgin Mobile', 'code' => 'VGM'],
            ['name' => 'Boost Mobile', 'code' => 'BTM'],
            ['name' => 'Rodgers Wireless', 'code' => 'RGS'],
            ['name' => 'Cricket Wireless', 'code' => 'CRK'],
            ['name' => 'MetroPCS', 'code' => 'MPCS'],
            ['name' => 'Straight Talk', 'code' => 'STW'],
            ['name' => 'Republic Wireless', 'code' => 'RBW']
        ];

        foreach ($carriers as $carrier) {
            MobileCarrier::create($carrier);
        }
    }
}
