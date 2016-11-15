<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Address;
use App\Http\Models\API\State;
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
            'country',
            'organization',
            'line_1',
            'line_2',
            'city',
            'state',
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

    /** @test */
    public function can_get_addresses_pages()
    {
        $this->get('/api/v1/addresses?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);

    }

    /** @test */
    public function fails_to_get_addresses_pages_without_auth()
    {
        $this->get('/api/v1/addresses?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_address_by_id()
    {
        $this->get('/api/v1/addresses/' . Address::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_address_by_id_without_auth()
    {
        $this->get('/api/v1/addresses/' . Address::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }


    /** @test */
    public function can_create_address()
    {
        $state = State::get()->random();
        $country = $state->country;
        $account = Account::get()->random();
        $address = [
            'account_id' => $account->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'addressee' => $account->format_full_name(),
            'organization' => 'Jedi Knight Academy',
            'line_1' => 'address line 1',
            'line_2' => 'address line 2',
            'city' => 'Awesome City',
            'zip' => '123456789'
        ];
        $this->post('/api/v1/addresses', $address, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_address_without_auth()
    {
        $state = State::get()->random();
        $country = $state->country;
        $account = Account::get()->random();
        $address = [
            'account_id' => $account->id,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'addressee' => $account->format_full_name(),
            'organization' => 'Jedi Knight Academy',
            'line_1' => 'address line 1',
            'line_2' => 'address line 2',
            'city' => 'Awesome City',
            'zip' => '123456789'
        ];
        $this->post('/api/v1/addresses', $address)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_address_with_country_code()
    {
        $state = State::get()->random();
        $country = $state->country;
        $account = Account::get()->random();
        $address = [
            'account_id' => $account->id,
            'country_code' => $country->code,
            'state_id' => $state->id,
            'addressee' => $account->format_full_name(),
            'organization' => 'Jedi Knight Academy',
            'line_1' => 'address line 1',
            'line_2' => 'address line 2',
            'city' => 'Awesome City',
            'zip' => '123456789'
        ];
        $this->post('/api/v1/addresses', $address, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_create_address_with_state_code()
    {
        $state = State::get()->random();
        $country = $state->country;
        $account = Account::get()->random();
        $address = [
            'account_id' => $account->id,
            'country_id' => $country->id,
            'state_code' => $state->code,
            'addressee' => $account->format_full_name(),
            'organization' => 'Jedi Knight Academy',
            'line_1' => 'address line 1',
            'line_2' => 'address line 2',
            'city' => 'Awesome City',
            'zip' => '123456789'
        ];
        $this->post('/api/v1/addresses', $address, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_create_address_with_username()
    {
        $state = State::get()->random();
        $country = $state->country;
        $account = Account::get()->random();
        $address = [
            'username' => $account->username,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'addressee' => $account->format_full_name(),
            'organization' => 'Jedi Knight Academy',
            'line_1' => 'address line 1',
            'line_2' => 'address line 2',
            'city' => 'Awesome City',
            'zip' => '123456789'
        ];
        $this->post('/api/v1/addresses', $address, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_create_address_with_identifier()
    {
        $state = State::get()->random();
        $country = $state->country;
        $account = Account::get()->random();
        $address = [
            'identifier' => $account->identifier,
            'country_id' => $country->id,
            'state_id' => $state->id,
            'addressee' => $account->format_full_name(),
            'organization' => 'Jedi Knight Academy',
            'line_1' => 'address line 1',
            'line_2' => 'address line 2',
            'city' => 'Awesome City',
            'zip' => '123456789'
        ];
        $this->post('/api/v1/addresses', $address, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_delete_address_by_id()
    {
        $this->delete('/api/v1/addresses', ['id' => Address::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_address_by_id_without_auth()
    {
        $this->delete('/api/v1/addresses', ['id' => Address::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
