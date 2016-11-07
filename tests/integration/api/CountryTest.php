<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Country;

class CountryTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'code',
            'abbreviation',
            'label',
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
    public function can_get_country_pages()
    {
        $this->get('/api/v1/countries?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_country_pages_without_auth()
    {
        $this->get('/api/v1/countries?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_country_by_id()
    {
        $this->get('/api/v1/countries/' . Country::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_country_by_id_without_auth()
    {
        $this->get('/api/v1/countries/' . Country::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_country_by_code()
    {
        $this->get('/api/v1/countries/code/' . Country::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_country_by_code_without_auth()
    {
        $this->get('/api/v1/countries/code/' . Country::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_country()
    {
        $country = ['label' => 'Moon', 'code' => 'MOO', 'abbreviation' => 'MN'];
        $this->post('/api/v1/countries', $country, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fail_to_create_country_without_auth()
    {
        $country = ['label' => 'Moon', 'code' => 'MOO', 'abbreviation' => 'MN'];
        $this->post('/api/v1/countries', $country)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_country_by_id()
    {
        $this->delete('/api/v1/countries', ['id' => Country::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_country_by_id_without_auth()
    {
        $this->delete('/api/v1/countries', ['id' => Country::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_country_by_code()
    {
        $this->delete('/api/v1/countries', ['code' => Country::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_country_by_code_without_auth()
    {
        $this->delete('/api/v1/countries', ['code' => Country::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
