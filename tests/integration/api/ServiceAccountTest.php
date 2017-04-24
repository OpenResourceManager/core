<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\ServiceAccount;
use App\Http\Models\API\Duty;

class ServiceAccountTest extends TestCase
{
    use DatabaseTransactions;

    protected $itemStructureResponse = [
        'data' => [
            'id',
            'account_id',
            'identifier',
            'username',
            'password',
            'disabled',
            'expired',
            'expires',
            'updated',
            'created'
        ]
    ];

    protected $itemStructureDeclassifiedResponse = [
        'data' => [
            'id',
            'account_id',
            'identifier',
            'username',
            'password',
            'disabled',
            'expired',
            'expires',
            'updated',
            'created'
        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Duty::class, 5)->create();
        factory(Account::class, 150)->create();
        factory(ServiceAccount::class, 105)->create();
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
    public function can_get_service_account_pages()
    {
        $this->get('/api/v1/service-accounts?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function can_get_service_account_by_id()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->get('/api/v1/service-accounts/' . $alias->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_get_service_account_by_username()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->get('/api/v1/service-accounts/username/' . $alias->username, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_service_accounts_without_auth()
    {
        $this->get('/api/v1/service-accounts')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_service_account_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->get('/api/v1/service-accounts/' . $alias->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_service_account_by_username_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->get('/api/v1/service-accounts/username/' . $alias->username)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_service_account()
    {
        Account::create(lukeSkywalkerAccount());

        $this->post('/api/v1/service-accounts', deathStartServiceAccount(), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_service_account_without_auth()
    {
        Account::create(lukeSkywalkerAccount());

        $this->post('/api/v1/service-accounts', deathStartServiceAccount())
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_destroy_service_account_by_id()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->delete('/api/v1/service-accounts', ['id' => $alias->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_destroy_service_account_by_username()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->delete('/api/v1/service-accounts', ['username' => $alias->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function fails_to_destroy_service_account_by_id_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->delete('/api/v1/service-accounts', ['id' => $alias->id])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_destroy_service_account_by_identifier_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->delete('/api/v1/service-accounts', ['identifier' => $alias->identifier])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_destroy_service_account_by_username_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = ServiceAccount::create(deathStartServiceAccount());

        $this->delete('/api/v1/service-accounts', ['username' => $alias->username])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /**
     * @todo Test classified attribute access
     */
}
