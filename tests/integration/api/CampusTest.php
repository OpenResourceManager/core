<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Campus;

class CampusTest extends TestCase
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
            'updated',
            'created',

        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Campus::class, 250)->create();
        $this->logIn();
    }

    /** @test */
    public function can_get_campus_pages()
    {
        $this->get('/api/v1/campuses?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_campus_pages_without_auth()
    {
        $this->get('/api/v1/campuses?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_campus_by_id()
    {
        $this->get('/api/v1/campuses/' . Campus::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_campus_by_id_without_auth()
    {
        $this->get('/api/v1/campuses/' . Campus::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_campus_by_code()
    {
        $this->get('/api/v1/campuses/code/' . Campus::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_campus_by_code_without_auth()
    {
        $this->get('/api/v1/campuses/code/' . Campus::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_campus()
    {
        $this->post('/api/v1/campuses', ['label' => 'The Campus', 'code' => 'CODZE1234'], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_campus_without_auth()
    {
        $this->post('/api/v1/campuses', ['label' => 'The Campus', 'code' => 'CODZE1234'])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_campus_by_id()
    {
        $this->delete('/api/v1/campuses', ['id' => Campus::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_campus_by_id_without_auth()
    {
        $this->delete('/api/v1/campuses', ['id' => Campus::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_campus_by_code()
    {
        $this->delete('/api/v1/campuses', ['code' => Campus::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_campus_by_code_without_auth()
    {
        $this->delete('/api/v1/campuses', ['code' => Campus::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
