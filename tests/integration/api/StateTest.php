<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\State;
use App\Http\Models\API\Country;

class StateTest extends TestCase
{

    /**
     * The expected paginated structure
     *
     * @var array
     */
    protected $paginatedStructure = [
        'data' => [],
        'meta' => [
            'pagination' => [
                'total',
                'count',
                'per_page',
                'current_page',
                'total_pages',
                'links' => [
                    'previous'
                ]
            ]
        ]
    ];

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'code',
            'label',
            'country',
            'updated',
            'created',

        ]
    ];

    public function setUp()
    {
        parent::setUp();
        $this->logIn();
    }

    /** @test */
    public function can_get_state_pages()
    {
        $this->get('/api/v1/states?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_state_pages_without_auth()
    {
        $this->get('/api/v1/states?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_state_by_id()
    {
        $this->get('/api/v1/states/' . State::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_state_by_id_without_auth()
    {
        $this->get('/api/v1/states/' . State::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_state_by_code()
    {
        $this->get('/api/v1/states/code/' . State::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_state_by_code_without_auth()
    {
        $this->get('/api/v1/states/code/' . State::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_state()
    {
        $state = ['country_id' => Country::get()->random()->id, 'label' => 'Moon', 'code' => 'MOO'];
        $this->post('/api/v1/states', $state, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fail_to_create_state_without_auth()
    {
        $state = ['country_id' => Country::get()->random()->id, 'label' => 'Moon', 'code' => 'MOO'];
        $this->post('/api/v1/states', $state)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_state_by_country_code()
    {
        $state = ['country_code' => Country::get()->random()->code, 'label' => 'Moon', 'code' => 'MOO'];
        $this->post('/api/v1/states', $state, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fail_to_create_state_by_country_code_without_auth()
    {
        $state = ['country_code' => Country::get()->random()->code, 'label' => 'Moon', 'code' => 'MOO'];
        $this->post('/api/v1/states', $state)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_state_by_id()
    {
        $this->delete('/api/v1/states', ['id' => State::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_state_by_id_without_auth()
    {
        $this->delete('/api/v1/states', ['id' => State::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_state_by_code()
    {
        $this->delete('/api/v1/states', ['code' => State::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_state_by_code_without_auth()
    {
        $this->delete('/api/v1/states', ['code' => State::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
