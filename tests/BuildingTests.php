<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Model\Campus;

class BuildingTest extends ApiTester
{

    use \tests\helpers\Factory;

    /** @test */
    public function it_creates_a_new_building_given_valid_parameters()
    {
        $result = $this->getJson('api/v1/buildings', 'POST', $this->getStub());

        $this->assertResponseStatus(201);
        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code');
        $this->assertObjectHasAttributes($result->result, 'id', 'message');
    }

    /** @test */
    public function it_422s_if_incorrect_parameters_are_provided_and_validation_fails()
    {
        $result = $this->getJson('api/v1/buildings', 'POST');

        $this->assertResponseStatus(422);
        $this->assertObjectHasAttributes($result, 'error', 'success', 'status_code');
    }

    /** @test */
    public function it_pages_building_results()
    {
        $this->times(5)->make('App\Model\Building');

        $result = $this->getJson('api/v1/buildings', 'GET', ['page' => 2, 'limit' => 3]);

        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code', 'pagination');
        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_buildings()
    {
        $this->times(5)->make('App\Model\Building');

        $result = $this->getJson('api/v1/buildings');

        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code', 'pagination');
        $this->assertResponseOk();
    }

    /** @test */
    public function it_fetches_a_single_building()
    {
        $this->times(1)->make('App\Model\Building');

        $result = $this->getJson('api/v1/buildings/1');

        $this->assertResponseOk();
        $this->assertObjectHasAttributes($result, 'result', 'success', 'status_code');
        $this->assertObjectHasAttributes(
            $result->result,
            'id',
            'campus_id',
            'code',
            'name'
        );
    }

    /** @test */
    public function it_404s_if_a_building_is_not_found()
    {
        $this->getJson('api/v1/buildings/x');

        $this->assertResponseStatus(404);
    }

    protected function getStub()
    {
        $campusIds = Campus::get()->lists('id')->all();

        $buildingPostfixes = [
            'Center',
            'Hall',
            'House',
            'Building',
            'Court',
            'Annex',
            'Pavilion',
        ];

        $directions = [
            'North',
            'South',
            'East',
            'West',
        ];

        $name = preg_replace('/\s\s+/', ' ', $this->fake->unique()->randomElement([
            trim($this->fake->optional()->firstName . ' ' . $this->fake->unique()->lastName . ' ' . $this->fake->randomElement($buildingPostfixes)),
            trim($this->fake->streetName . ' ' . $this->fake->randomElement($buildingPostfixes)),
            trim($this->fake->randomElement($directions) . ' ' . $this->fake->optional()->lastName . ' ' . $this->fake->randomElement($buildingPostfixes))
        ]));
        $num = $this->fake->unique()->randomNumber($nbDigits = 3);
        $code = strtoupper(trim(substr($name, 0, 3)) . $num);

        return [
            'campus_id' => $this->fake->randomElement($campusIds),
            'code' => $code,
            'name' => $name
        ];
    }
}
