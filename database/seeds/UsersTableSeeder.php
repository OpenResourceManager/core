<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@domain.tld',
            'password' => bcrypt('Cascade')
        ]);

        $admin->attachRole(Role::where('name', 'admin')->first());
    }
}
