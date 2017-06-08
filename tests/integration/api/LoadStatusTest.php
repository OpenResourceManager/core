<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\LoadStatus;

class LoadStatusTest extends TestCase
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
        factory(LoadStatus::class, 110)->create();
        $this->logIn();
    }


    /** @test */
    public function can_get_load_status_pages()
    {
        $this->get('/api/v1/load-statuses?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_load_status_pages_without_auth()
    {
        $this->get('/api/v1/load-statuses?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_load_status()
    {
        $this->get('/api/v1/load-statuses/' . LoadStatus::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_load_status_without_auth()
    {
        $this->get('/api/v1/load-statuses/' . LoadStatus::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_load_status_by_code()
    {
        $this->get('/api/v1/load-statuses/code/' . LoadStatus::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_load_status_by_code_without_auth()
    {
        $this->get('/api/v1/load-statuses/code/' . LoadStatus::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_load_status()
    {
        $this->post('/api/v1/load-statuses', [
            'label' => 'The Code',
            'code' => 'CODZE1234'
        ], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_load_status_without_auth()
    {
        $this->post('/api/v1/courses', [
            'label' => 'The Code',
            'code' => 'CODZE1234'
        ])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_load_status_by_id()
    {
        $this->delete('/api/v1/load-statuses', ['id' => LoadStatus::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_load_status_by_id_without_auth()
    {
        $this->delete('/api/v1/load-statuses', ['id' => LoadStatus::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_load_status_by_code()
    {
        $this->delete('/api/v1/load-statuses', ['code' => LoadStatus::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_load_status_by_code_without_auth()
    {
        $this->delete('/api/v1/load-statuses', ['code' => LoadStatus::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
