<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\AliasAccount;
use App\Http\Models\API\Duty;

class AliasAccountTest extends TestCase
{
    use DatabaseTransactions;

    protected $itemStructureResponse = [
        'data' => [
            'id',
            'account_id',
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
        factory(AliasAccount::class, 105)->create();
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
    public function can_get_alias_account_pages()
    {
        $this->get('/api/v1/alias-accounts?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function can_get_alias_account_by_id()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->get('/api/v1/alias-accounts/' . $alias->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function can_get_alias_account_by_username()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->get('/api/v1/alias-accounts/username/' . $alias->username, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_alias_accounts_without_auth()
    {
        $this->get('/api/v1/alias-accounts')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_alias_account_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->get('/api/v1/alias-accounts/' . $alias->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_get_alias_account_by_username_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->get('/api/v1/alias-accounts/username/' . $alias->username)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_alias_account()
    {
        Account::create(lukeSkywalkerAccount());

        $this->post('/api/v1/alias-accounts', larsDunestriderAlias(), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_alias_account_without_auth()
    {
        Account::create(lukeSkywalkerAccount());

        $this->post('/api/v1/alias-accounts', larsDunestriderAlias())
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_destroy_alias_account_by_id()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->delete('/api/v1/alias-accounts', ['id' => $alias->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_destroy_alias_account_by_username()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->delete('/api/v1/alias-accounts', ['username' => $alias->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function fails_to_destroy_alias_account_by_id_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->delete('/api/v1/alias-accounts', ['id' => $alias->id])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_destroy_alias_account_by_identifier_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->delete('/api/v1/alias-accounts', ['identifier' => $alias->identifier])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function fails_to_destroy_alias_account_by_username_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $alias = AliasAccount::create(larsDunestriderAlias());

        $this->delete('/api/v1/alias-accounts', ['username' => $alias->username])
            ->assertResponseStatus(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /**
     * @todo Test classified attribute access
     */
}
