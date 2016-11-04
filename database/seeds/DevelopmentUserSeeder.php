<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class DevelopmentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceViewerUser = User::create([
            'name' => 'Service Viewer',
            'username' => 'serviceViewer',
            'email' => 'serviceViewer@domain.tld',
            'password' => bcrypt('Cascade')
        ]);
        $accountAdmin = User::create([
            'name' => 'Account Admin',
            'username' => 'accountAdmin',
            'email' => 'accountAdmin@domain.tld',
            'password' => bcrypt('Cascade')
        ]);
        $accountManager = User::create([
            'name' => 'Account Manager',
            'username' => 'accountManager',
            'email' => 'accountManager@domain.tld',
            'password' => bcrypt('Cascade')
        ]);
        $accountViewer = User::create([
            'name' => 'Account Viewer',
            'username' => 'accountViewer',
            'email' => 'accountViewer@domain.tld',
            'password' => bcrypt('Cascade')
        ]);
        $accountBasic = User::create([
            'name' => 'Account Basic',
            'username' => 'accountBasic',
            'email' => 'accountBasic@domain.tld',
            'password' => bcrypt('Cascade')
        ]);
        $applicationManager = User::create([
            'name' => 'Application Manager',
            'username' => 'applicationManager',
            'email' => 'applicationManager@domain.tld',
            'password' => bcrypt('Cascade')
        ]);
        $institutionalManager = User::create([
            'name' => 'Institutional Manager',
            'username' => 'institutionalManager',
            'email' => 'institutionalManager@domain.tld',
            'password' => bcrypt('Cascade')
        ]);
        $resourceViewer = User::create([
            'name' => 'Resource Viewer',
            'username' => 'resourceViewer',
            'email' => 'resourceViewer@domain.tld',
            'password' => bcrypt('Cascade')
        ]);

        $serviceViewerUser->attachRole(Role::where('name', 'service-viewer')->first());
        $accountAdmin->attachRole(Role::where('name', 'account-admin')->first());
        $accountManager->attachRole(Role::where('name', 'account-manager')->first());
        $accountViewer->attachRole(Role::where('name', 'account-viewer')->first());
        $accountBasic->attachRole(Role::where('name', 'account-basic')->first());
        $applicationManager->attachRole(Role::where('name', 'application-manager')->first());
        $institutionalManager->attachRole(Role::where('name', 'institution-manager')->first());
        $resourceViewer->attachRole(Role::where('name', 'resource-viewer')->first());

    }
}
