<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\MobileCarrier;

class MobileCarrierTest extends TestCase
{

    use DatabaseTransactions;

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
                'links' => []
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
    public function can_get_mobile_carrier_pages()
    {
        $this->get('/api/v1/mobile-carriers', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function can_get_mobile_carrier_by_id()
    {
        $this->get('/api/v1/mobile-carriers/' . MobileCarrier::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_mobile_carrier_by_id_without_auth()
    {
        $this->get('/api/v1/mobile-carriers/' . MobileCarrier::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_mobile_carrier_by_code()
    {
        $this->get('/api/v1/mobile-carriers/code/' . MobileCarrier::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_mobile_carrier_by_code_without_auth()
    {
        $this->get('/api/v1/mobile-carriers/code/' . MobileCarrier::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_mobile_carrier()
    {
        $this->post('/api/v1/mobile-carriers', jediMasterMobileCarrier(), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_mobile_carrier_without_auth()
    {
        $this->post('/api/v1/mobile-carriers', jediMasterMobileCarrier())
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_mobile_carrier()
    {
        $this->delete('/api/v1/mobile-carriers', ['id' => MobileCarrier::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_mobile_carrier_without_auth()
    {
        $this->delete('/api/v1/mobile-carriers', ['id' => MobileCarrier::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_mobile_carrier_by_code()
    {
        $this->delete('/api/v1/mobile-carriers', ['code' => MobileCarrier::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_mobile_carrier_by_code_without_auth()
    {
        $this->delete('/api/v1/mobile-carriers', ['code' => MobileCarrier::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
