<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Apikey;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class GenApikey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:apikey
                            {--label= : The label or application name for the API Key.}

                            {--get : The key has global GET permissions.}
                            {--post : The key has global POST permissions.}
                            {--delete : The key has global DELETE permissions.}

                            {--getAddress : The key specifically has address GET permissions.}
                            {--postAddress : The key specifically has address POST permissions.}
                            {--deleteAddress : The key specifically has address DELETE permissions.}

                            {--getBuilding : The key specifically has building GET permissions.}
                            {--postBuilding : The key specifically has building POST permissions.}
                            {--deleteBuilding : The key specifically has building DELETE permissions.}

                            {--getCampus : The key specifically has campus GET permissions.}
                            {--postCampus : The key specifically has campus POST permissions.}
                            {--deleteCampus : The key specifically has campus DELETE permissions.}

                            {--getCountry : The key specifically has country GET permissions.}
                            {--postCountry : The key specifically has country POST permissions.}
                            {--deleteCountry : The key specifically has country DELETE permissions.}

                            {--getCourse : The key specifically has course GET permissions.}
                            {--postCourse : The key specifically has course POST permissions.}
                            {--deleteCourse : The key specifically has course DELETE permissions.}

                            {--getDepartment : The key specifically has department GET permissions.}
                            {--postDepartment : The key specifically has department POST permissions.}
                            {--deleteDepartment : The key specifically has department DELETE permissions.}

                            {--getEmail : The key specifically has email GET permissions.}
                            {--postEmail : The key specifically has email POST permissions.}
                            {--deleteEmail : The key specifically has email DELETE permissions.}

                            {--getPassword : The key specifically has password GET permissions.}
                            {--postPassword : The key specifically has password POST permissions.}
                            {--deletePassword : The key specifically has password DELETE permissions.}

                            {--getBirthDate : The key specifically has birth date GET permissions.}
                            {--postBirthDate : The key specifically has birth date POST permissions.}
                            {--deleteBirthDate : The key specifically has birth date DELETE permissions.}

                            {--getPhone : The key specifically has phone GET permissions.}
                            {--postPhone : The key specifically has phone POST permissions.}
                            {--deletePhone : The key specifically has phone DELETE permissions.}

                            {--getRole : The key specifically has role GET permissions.}
                            {--postRole : The key specifically has role POST permissions.}
                            {--deleteRole : The key specifically has role DELETE permissions.}

                            {--getRoom : The key specifically has room GET permissions.}
                            {--postRoom : The key specifically has room POST permissions.}
                            {--deleteRoom : The key specifically has room DELETE permissions.}

                            {--getState : The key specifically has state GET permissions.}
                            {--postState : The key specifically has state POST permissions.}
                            {--deleteState : The key specifically has state DELETE permissions.}

                            {--getUser : The key specifically has user GET permissions.}
                            {--postUser : The key specifically has user POST permissions.}
                            {--deleteUser : The key specifically has user DELETE permissions.}

                            {--getMobileCarrier : The key specifically has mobile carrier GET permissions.}
                            {--postMobileCarrier : The key specifically has mobile carrier POST permissions.}
                            {--deleteMobileCarrier : The key specifically has mobile carrier DELETE permissions.}
                            
                            {--getSSN : The key specifically has social security number GET permissions.}
                            {--postSSN : The key specifically has social security number POST permissions.}
                            {--deleteSSN : The key specifically has social security number DELETE permissions.}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API Key';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            ['--label', InputOption::VALUE_REQUIRED, 'The label or application name for the API Key.'],

            ['--get', InputOption::VALUE_NONE, 'The key has global GET permissions.'],
            ['--post', InputOption::VALUE_NONE, 'The key has global POST permissions.'],
            ['--delete', InputOption::VALUE_NONE, 'The key has global DELETE permissions.'],

            ['--getAddress', InputOption::VALUE_NONE, 'The key specifically has address GET permissions.'],
            ['--postAddress', InputOption::VALUE_NONE, 'The key specifically has address POST permissions.'],
            ['--deleteAddress', InputOption::VALUE_NONE, 'The key specifically has address DELETE permissions.'],

            ['--getBuilding', InputOption::VALUE_NONE, 'The key specifically has building GET permissions.'],
            ['--postBuilding', InputOption::VALUE_NONE, 'The key specifically has building POST permissions.'],
            ['--deleteBuilding', InputOption::VALUE_NONE, 'The key specifically has building DELETE permissions.'],

            ['--getCampus', InputOption::VALUE_NONE, 'The key specifically has campus GET permissions.'],
            ['--postCampus', InputOption::VALUE_NONE, 'The key specifically has campus POST permissions.'],
            ['--deleteCampus', InputOption::VALUE_NONE, 'The key specifically has campus DELETE permissions.'],

            ['--getCountry', InputOption::VALUE_NONE, 'The key specifically has country GET permissions.'],
            ['--postCountry', InputOption::VALUE_NONE, 'The key specifically has country POST permissions.'],
            ['--deleteCountry', InputOption::VALUE_NONE, 'The key specifically has country DELETE permissions.'],

            ['--getCourse', InputOption::VALUE_NONE, 'The key specifically has course GET permissions.'],
            ['--postCourse', InputOption::VALUE_NONE, 'The key specifically has course POST permissions.'],
            ['--deleteCourse', InputOption::VALUE_NONE, 'The key specifically has course DELETE permissions.'],

            ['--getDepartment', InputOption::VALUE_NONE, 'The key specifically has department GET permissions.'],
            ['--postDepartment', InputOption::VALUE_NONE, 'The key specifically has department POST permissions.'],
            ['--deleteDepartment', InputOption::VALUE_NONE, 'The key specifically has department DELETE permissions.'],

            ['--getEmail', InputOption::VALUE_NONE, 'The key specifically has email GET permissions.'],
            ['--postEmail', InputOption::VALUE_NONE, 'The key specifically has email POST permissions.'],
            ['--deleteEmail', InputOption::VALUE_NONE, 'The key specifically has email DELETE permissions.'],

            ['--getPassword', InputOption::VALUE_NONE, 'The key specifically has password GET permissions.'],
            ['--postPassword', InputOption::VALUE_NONE, 'The key specifically has password POST permissions.'],
            ['--deletePassword', InputOption::VALUE_NONE, 'The key specifically has password DELETE permissions.'],

            ['--getBirthDate', InputOption::VALUE_NONE, 'The key specifically has birth date GET permissions.'],
            ['--postBirthDate', InputOption::VALUE_NONE, 'The key specifically has birth date POST permissions.'],
            ['--deleteBirthDate', InputOption::VALUE_NONE, 'The key specifically has birth date DELETE permissions.'],

            ['--getPhone', InputOption::VALUE_NONE, 'The key specifically has phone GET permissions.'],
            ['--postPhone', InputOption::VALUE_NONE, 'The key specifically has phone POST permissions.'],
            ['--deletePhone', InputOption::VALUE_NONE, 'The key specifically has phone DELETE permissions.'],

            ['--getRole', InputOption::VALUE_NONE, 'The key specifically has role GET permissions.'],
            ['--postRole', InputOption::VALUE_NONE, 'The key specifically has role POST permissions.'],
            ['--deleteRole', InputOption::VALUE_NONE, 'The key specifically has role DELETE permissions.'],

            ['--getRoom', InputOption::VALUE_NONE, 'The key specifically has room GET permissions.'],
            ['--postRoom', InputOption::VALUE_NONE, 'The key specifically has room POST permissions.'],
            ['--deleteRoom', InputOption::VALUE_NONE, 'The key specifically has room DELETE permissions.'],

            ['--getState', InputOption::VALUE_NONE, 'The key specifically has state GET permissions.'],
            ['--postState', InputOption::VALUE_NONE, 'The key specifically has state POST permissions.'],
            ['--deleteState', InputOption::VALUE_NONE, 'The key specifically has state DELETE permissions.'],

            ['--getUser', InputOption::VALUE_NONE, 'The key specifically has user GET permissions.'],
            ['--postUser', InputOption::VALUE_NONE, 'The key specifically has user POST permissions.'],
            ['--deleteUser', InputOption::VALUE_NONE, 'The key specifically has user DELETE permissions.'],

            ['--getMobileCarrier', InputOption::VALUE_NONE, 'The key specifically has mobile carrier GET permissions.'],
            ['--postMobileCarrier', InputOption::VALUE_NONE, 'The key specifically has mobile carrier POST permissions.'],
            ['--deleteMobileCarrier', InputOption::VALUE_NONE, 'The key specifically has mobile carrier DELETE permissions.'],

            ['--getSSN', InputOption::VALUE_NONE, 'The key specifically has social security number GET permissions.'],
            ['--postSSN', InputOption::VALUE_NONE, 'The key specifically has social security number POST permissions.'],
            ['--deleteSSN', InputOption::VALUE_NONE, 'The key specifically has social security number DELETE permissions.'],
        );
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $label = $this->option('label');

        if ($label && !empty($label) && !is_null($label)) {

            do {
                $token = Str::quickRandom(64);
                $exists = Apikey::where('key', $token)->first();
            } while (!empty($exists));

            $key = new ApiKey;
            $key->key = $token;
            $key->app_name = $label;

            $key->can_get = $this->option('get') ? true : false;
            $key->can_post = $this->option('post') ? true : false;
            $key->can_delete = $this->option('delete') ? true : false;

            $key->can_get_address = $this->option('getAddress') ? true : false;
            $key->can_post_address = $this->option('postAddress') ? true : false;
            $key->can_delete_address = $this->option('deleteAddress') ? true : false;

            $key->can_get_building = $this->option('getBuilding') ? true : false;
            $key->can_post_building = $this->option('postBuilding') ? true : false;
            $key->can_delete_building = $this->option('deleteBuilding') ? true : false;

            $key->can_get_campus = $this->option('getCampus') ? true : false;
            $key->can_post_campus = $this->option('postCampus') ? true : false;
            $key->can_delete_campus = $this->option('deleteCampus') ? true : false;

            $key->can_get_country = $this->option('getCountry') ? true : false;
            $key->can_post_country = $this->option('postCountry') ? true : false;
            $key->can_delete_country = $this->option('deleteCountry') ? true : false;

            $key->can_get_course = $this->option('getCourse') ? true : false;
            $key->can_post_course = $this->option('postCourse') ? true : false;
            $key->can_delete_course = $this->option('deleteCourse') ? true : false;

            $key->can_get_department = $this->option('getDepartment') ? true : false;
            $key->can_post_department = $this->option('postDepartment') ? true : false;
            $key->can_delete_department = $this->option('deleteDepartment') ? true : false;

            $key->can_get_email = $this->option('getEmail') ? true : false;
            $key->can_post_email = $this->option('postEmail') ? true : false;
            $key->can_delete_email = $this->option('deleteEmail') ? true : false;

            $key->can_get_password = $this->option('getPassword') ? true : false;
            $key->can_post_password = $this->option('postPassword') ? true : false;
            $key->can_delete_password = $this->option('deletePassword') ? true : false;

            $key->can_get_birth_date = $this->option('getBirthDate') ? true : false;
            $key->can_post_birth_date = $this->option('postBirthDate') ? true : false;
            $key->can_delete_birth_date = $this->option('deleteBirthDate') ? true : false;

            $key->can_get_phone = $this->option('getPhone') ? true : false;
            $key->can_post_phone = $this->option('postPhone') ? true : false;
            $key->can_delete_phone = $this->option('deletePhone') ? true : false;

            $key->can_get_role = $this->option('getRole') ? true : false;
            $key->can_post_role = $this->option('postRole') ? true : false;
            $key->can_delete_role = $this->option('deleteRole') ? true : false;

            $key->can_get_room = $this->option('getRoom') ? true : false;
            $key->can_post_room = $this->option('postRoom') ? true : false;
            $key->can_delete_room = $this->option('deleteRoom') ? true : false;

            $key->can_get_state = $this->option('getState') ? true : false;
            $key->can_post_state = $this->option('postState') ? true : false;
            $key->can_delete_state = $this->option('deleteState') ? true : false;

            $key->can_get_user = $this->option('getUser') ? true : false;
            $key->can_post_user = $this->option('postUser') ? true : false;
            $key->can_delete_user = $this->option('deleteUser') ? true : false;

            $key->can_get_mobile_carrier = $this->option('getMobileCarrier') ? true : false;
            $key->can_post_mobile_carrier = $this->option('postMobileCarrier') ? true : false;
            $key->can_delete_mobile_carrier = $this->option('deleteMobileCarrier') ? true : false;

            $key->can_get_social_security_number = $this->option('getSSN') ? true : false;
            $key->can_post_social_security_number = $this->option('postSSN') ? true : false;
            $key->can_delete_social_security_number = $this->option('deleteSSN') ? true : false;

            $key->save();

            $this->info($token);
        } else {
            $this->error('You must supply a label for this key!');
        }
    }
}
