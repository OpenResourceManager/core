<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\School;

class SchoolTest extends TestCase
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
            'created'
        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(School::class, 250)->create();
        $this->logIn();
    }


    /** @test */
    public function can_get_schools_pages()
    {
        $this->get('/api/v1/schools?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_schools_pages_without_auth()
    {
        $this->get('/api/v1/schools?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_school()
    {
        $this->get('/api/v1/schools/' . School::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_school_without_auth()
    {
        $this->get('/api/v1/schools/' . School::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_school_by_code()
    {
        $this->get('/api/v1/schools/code/' . School::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_school_by_code_without_auth()
    {
        $this->get('/api/v1/schools/code/' . School::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_school()
    {
        $this->post('/api/v1/schools', [
            'label' => 'The Code',
            'code' => 'CODZE1234'
        ], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_school_without_auth()
    {
        $this->post('/api/v1/schools', [
            'label' => 'The Code',
            'code' => 'CODZE1234'
        ])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_school_by_id()
    {
        $this->delete('/api/v1/schools', ['id' => School::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_school_by_id_without_auth()
    {
        $this->delete('/api/v1/schools', ['id' => School::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_school_by_code()
    {
        $this->delete('/api/v1/schools', ['code' => School::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_school_by_code_without_auth()
    {
        $this->delete('/api/v1/schools', ['code' => School::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
