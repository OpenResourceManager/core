<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\MobilePhone;
use App\Http\Models\API\Duty;

class MobilePhoneTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $errorStructure = ['message', 'status_code'];

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'account_id',
            'number',
            'country_code',
            'verified',
            'verification_token',
            'mobile_carrier',
            'updated',
            'created',

        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Duty::class, 5)->create();
        factory(Account::class, 150)->create();
        factory(MobilePhone::class, 200)->create();
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
    public function can_get_mobile_phone_pages()
    {
        $this->get('/api/v1/mobile-phones?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function can_get_mobile_phone_by_id()
    {
        $this->get('/api/v1/mobile-phones/' . MobilePhone::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

}
