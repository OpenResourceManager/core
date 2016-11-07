<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Campus;
use App\Http\Models\API\Building;

class BuildingTest extends TestCase
{

    use DatabaseTransactions;

    protected $itemStructureResponse = [
        'data' => [
            'id',
            'code',
            'label',
            'campus_id',
            'updated',
            'created',

        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Campus::class, 4)->create();
        factory(Building::class, 300)->create();
        $this->logIn();
    }

    /** @test */
    public function can_get_building_pages()
    {
        $this->get('/api/v1/buildings?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_building_pages_without_auth()
    {
        $this->get('/api/v1/buildings?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_building_by_id()
    {
        $this->get('/api/v1/buildings/' . Building::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_get_building_by_code()
    {
        $this->get('/api/v1/buildings/code/' . Building::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_create_building()
    {
        $this->post('/api/v1/buildings', ['label' => 'The Building', 'campus_id' => Campus::get()->random()->id, 'code' => 'CODZE1234'], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_create_building_with_campus_code()
    {
        $this->post('/api/v1/buildings', ['label' => 'The Building', 'campus_code' => Campus::get()->random()->code, 'code' => 'CODZE1234'], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_delete_building_by_id()
    {
        $this->delete('/api/v1/buildings', ['id' => Building::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function can_delete_building_by_code()
    {
        $this->delete('/api/v1/buildings', ['code' => Building::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }
}
