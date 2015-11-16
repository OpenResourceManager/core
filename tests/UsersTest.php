<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Model\User;

class UsersTest extends ApiTester
{

    /** @test */
    public function it_fetches_users()
    {
        $this->times(5)->makeUser();

        $this->getJson('api/v1/users');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_user()
    {
        $this->times(1)->makeUser();

        dd($this->getJson('api/v1/users/1'));

        $this->assertResponseOk();
    }


    /**
     * @param array $userFields
     */
    private function makeUser($userFields = [])
    {
        while ($this->times--) {

            $user = array_merge([
                'user_identifier' => $this->fake->unique()->randomNumber($nbDigits = 7, $strict = true),
                'name_prefix' => $this->fake->optional()->title,
                'name_first' => $this->fake->firstName,
                'name_middle' => $this->fake->optional()->firstName,
                'name_last' => $this->fake->lastName,
                'name_postfix' => $this->fake->optional()->title,
                'name_phonetic' => $this->fake->optional()->firstName,
                'username' => $this->fake->unique()->userName
            ], $userFields);

            User::create($user);
        }
    }
}
