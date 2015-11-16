<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends ApiTester
{

    use \tests\helpers\Factory;

    /** @test */
    public function it_creates_a_new_user_given_valid_parameters()
    {
        $result = $this->getJson('api/v1/users', 'POST', $this->getStub());

        $this->assertResponseStatus(201);
        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code');
        $this->assertObjectHasAttributes($result->result, 'id', 'message');
    }

    /** @test */
    public function it_422s_if_incorrect_parameters_are_provided()
    {
        $result = $this->getJson('api/v1/users', 'POST');

        dd($result);

        $this->assertResponseStatus(422);
        // $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code');
        // $this->assertObjectHasAttributes($result->result, 'id', 'message');
    }

    /** @test */
    public function it_fetches_users()
    {
        $this->times(5)->make('App\Model\User');

        $result = $this->getJson('api/v1/users');
        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code');
        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_user()
    {
        $this->times(1)->make('App\Model\User');

        $result = $this->getJson('api/v1/users/1');

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code');
        $this->assertObjectHasAttributes(
            $result->result,
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
            'user_identifier' => strval($this->fake->unique()->randomNumber($nbDigits = 7, $strict = true)),
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
