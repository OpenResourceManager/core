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
        $this->times(5)->make('User');

        $this->getJson('api/v1/users');

        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_user()
    {
        $this->times(1)->make('User');

        $user = $this->getJson('api/v1/users/1')->result;

        $this->assertResponseOk();

        $this->assertObjectHasAttributes(
            $user,
            'id',
            'user_identifier',
            'username',
            'name_prefix',
            'name_first',
            'name_middle',
            'name_last',
            'name_postfix',
            'name_phonetic'
        );
    }

    /** @test */
    public function it_404s_if_a_user_is_not_found()
    {
        $this->getJson('api/v1/users/x');

        $this->assertResponseStatus(404);
    }


    protected function getStub()
    {
        return [
            'user_identifier' => $this->fake->unique()->randomNumber($nbDigits = 7, $strict = true),
            'name_prefix' => $this->fake->optional()->title,
            'name_first' => $this->fake->firstName,
            'name_middle' => $this->fake->optional()->firstName,
            'name_last' => $this->fake->lastName,
            'name_postfix' => $this->fake->optional()->title,
            'name_phonetic' => $this->fake->optional()->firstName,
            'username' => $this->fake->unique()->userName
        ];
    }

}
