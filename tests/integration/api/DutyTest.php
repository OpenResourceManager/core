<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Duty;

class DutyTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'code',
            'label',
            'created',
            'updated'
        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Duty::class, 150)->create();
        $this->logIn();
    }

    /**
     *
     *
     * Tests start here
     *
     *
     */

    /** @test */
    public function can_get_duty_pages()
    {
        $this->get('/api/v1/duties?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function can_get_duty_by_id()
    {
        $duty = Duty::create(jediMasterDuty());

        $this->get('/api/v1/duties/' . $duty->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_get_duty_by_code()
    {
        $duty = Duty::create(jediMasterDuty());

        $this->get('/api/v1/duties/code/' . $duty->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_duties_without_auth()
    {
        $this->get('/api/v1/duties')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_duty_without_auth()
    {
        $duty = Duty::create(jediMasterDuty());

        $this->get('/api/v1/duties/' . $duty->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_duty_by_code_without_auth()
    {
        $duty = Duty::create(jediMasterDuty());

        $this->get('/api/v1/duties/code/' . $duty->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_duty()
    {
        $this->post('/api/v1/duties', jediMasterDuty(), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_duty_without_auth()
    {
        $this->post('/api/v1/duties', jediMasterDuty())
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_destroy_duty_by_id()
    {
        $duty = Duty::create(jediMasterDuty());

        $this->delete('/api/v1/duties', ['id' => $duty->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_destroy_duty_by_code()
    {
        $duty = Duty::create(jediMasterDuty());

        $this->delete('/api/v1/duties', ['code' => $duty->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function fails_to_destroy_duty_by_id_without_auth()
    {
        $duty = Duty::create(jediMasterDuty());

        $this->delete('/api/v1/duties', ['id' => $duty->id])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_destroy_duty_by_code_without_auth()
    {
        $duty = Duty::create(jediMasterDuty());

        $this->delete('/api/v1/duties', ['code' => $duty->code])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
