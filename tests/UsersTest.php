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

        if (in_array('--verbose', $_SERVER['argv'], true)) {
            dd($result);
        }

        $this->assertResponseStatus(201);
        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code');
        $this->assertObjectHasAttributes($result->result, 'id', 'message');
    }

    /** @test */
    public function it_422s_if_incorrect_parameters_are_provided_and_validation_fails()
    {
        $result = $this->getJson('api/v1/users', 'POST');

        if (in_array('--verbose', $_SERVER['argv'], true)) {
            dd($result);
        }

        $this->assertResponseStatus(422);
        $this->assertObjectHasAttributes($result, 'error', 'success', 'status_code');
    }

    /** @test */
    public function it_pages_user_results()
    {
        $this->times(5)->make('App\Model\User');

        $result = $this->getJson('api/v1/users', 'GET', ['page' => 2, 'limit' => 3]);

        if (in_array('--verbose', $_SERVER['argv'], true)) {
            dd($result);
        }

        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code', 'pagination');
        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_users()
    {
        $this->times(5)->make('App\Model\User');

        $result = $this->getJson('api/v1/users');

        if (in_array('--verbose', $_SERVER['argv'], true)) {
            dd($result);
        }

        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code', 'pagination');
        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_user()
    {
        $this->times(1)->make('App\Model\User');

        $result = $this->getJson('api/v1/users/1');

        if (in_array('--verbose', $_SERVER['argv'], true)) {
            dd($result);
        }

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
        $result = $this->getJson('api/v1/users/x');

        if (in_array('--verbose', $_SERVER['argv'], true)) {
            dd($result);
        }

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
