<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;
use App\Http\Models\API\LoadStatus;

class AccountTest extends TestCase
{
    use DatabaseTransactions;

    protected $itemStructureResponse = [
        'data' => [
            'id',
            'identifier',
            'name_prefix',
            'name_first',
            'name_middle',
            'name_last',
            'name_postfix',
            'name_phonetic',
            'username',
            'load_status',
            'primary_duty',
            'ssn',
            'departments',
            'courses',
            'duties',
            'password',
            'birth_date',
            'emails',
            'mobile_phones',
            'addresses',
            'alias_accounts',
            'disabled',
            'expired',
            'expires',
            'updated',
            'created',
        ]
    ];

    protected $itemStructureDeclassifiedResponse = [
        'data' => [
            'id',
            'identifier',
            'name_prefix',
            'name_first',
            'name_middle',
            'name_last',
            'name_postfix',
            'name_phonetic',
            'username',
            'load_status',
            'primary_duty',
            'departments',
            'courses',
            'duties',
            'ssn',
            'password',
            'birth_date',
            'alias_accounts',
            'disabled',
            'expired',
            'expires',
            'updated',
            'created',
        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Duty::class, 5)->create();
        factory(Account::class, 150)->create();
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
    public function can_get_account_pages()
    {
        $this->get('/api/v1/accounts?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function can_get_account_by_id()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->get('/api/v1/accounts/' . $account->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_get_account_by_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->get('/api/v1/accounts/identifier/' . $account->identifier, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_get_account_by_username()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->get('/api/v1/accounts/username/' . $account->username, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_get_accounts_by_load_status()
    {


        $this->get('/api/v1/accounts/load-status/' . LoadStatus::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_get_accounts_by_load_status_code()
    {


        $this->get('/api/v1/accounts/load-status/code/' . LoadStatus::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_accounts_without_auth()
    {
        $this->get('/api/v1/accounts')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_account_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->get('/api/v1/accounts/' . $account->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_account_by_identifier_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->get('/api/v1/accounts/identifier/' . $account->identifier)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_account_by_username_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->get('/api/v1/accounts/username/' . $account->username)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_account()
    {
        $this->post('/api/v1/accounts', lukeSkywalkerAccount(), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @todo make this work */
    public function can_update_account()
    {
        $luke = lukeSkywalkerAccount();
        $jedi = Duty::create(jediMasterDuty());

        $response1 = $this->post('/api/v1/accounts', $luke, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);

        /*
         * @todo Verify that time stamps prove model has been updated
         $decoded1 = $response1->decodeResponseJson();
         $originalCreated = $decoded1['data']['created'];
         $originalUpdated = $decoded1['data']['updated'];

         $luke['name_postfix'] = '';

         $response2 = $this->post('/api/v1/accounts', $luke, ['Authorization' => 'Bearer ' . $this->bearer])
             ->seeStatusCode(201)
             ->seeJsonStructure($this->itemStructureResponse);

         $decoded2 = $response2->decodeResponseJson();
         $secondCreated = $decoded2['data']['created'];
         $secondUpdated = $decoded2['data']['updated'];

         $this->assertEquals($originalCreated, $originalUpdated);
         $this->assertNotEquals($secondCreated, $secondUpdated);
         $this->assertEquals($originalCreated, $secondCreated);
         $this->assertNotEquals($originalUpdated, $secondUpdated);*/
    }

    /** @test */
    public function fails_to_create_account_without_auth()
    {
        $this->post('/api/v1/accounts', lukeSkywalkerAccount())
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_destroy_account_by_id()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->delete('/api/v1/accounts', ['id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_destroy_account_by_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->delete('/api/v1/accounts', ['identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_destroy_account_by_username()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->delete('/api/v1/accounts', ['username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function fails_to_destroy_account_by_id_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->delete('/api/v1/accounts', ['id' => $account->id])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_destroy_account_by_identifier_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->delete('/api/v1/accounts', ['identifier' => $account->identifier])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_destroy_account_by_username_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());

        $this->delete('/api/v1/accounts', ['username' => $account->username])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /**
     * @todo Test classified attribute access
     */
}
