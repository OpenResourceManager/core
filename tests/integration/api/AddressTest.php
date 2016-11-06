<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Address;
use App\Http\Models\API\Account;

class AddressTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'account_id',
            'country_id',
            'organization',
            'line_1',
            'line_2',
            'city',
            'state_id',
            'zip',
            'latitude',
            'longitude',
            'updated',
            'created',

        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Account::class, 150)->create();
        factory(Address::class, 200)->create();
        $this->logIn();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
