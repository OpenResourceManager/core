<?php

use Illuminate\Database\Seeder;
use Krucas\Settings\Facades\Settings;

class TrashOUSetting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::set('ldap-use-trash-ou', true);
    }
}
