<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\Email;
use App\Http\Models\API\Duty;

class EmailTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'account_id',
            'address',
            'verified',
            'verification_token',
            'updated',
            'created',

        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Duty::class, 5)->create();
        factory(Account::class, 150)->create();
        factory(Email::class, 200)->create();
        $this->logIn();
    }

    /**
     * @return array
     */
    public function jediMasterDuty()
    {
        return [
            'code' => 'JEDI',
            'label' => 'Jedi Master'
        ];
    }

    /**
     *
     *
     * Tests start here
     *
     *
     */

    /** @test */
    public function can_get_email_pages()
    {
        $this->get('/api/v1/emails?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_email_pages_without_auth()
    {
        $this->get('/api/v1/emails?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_email_by_id()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/' . $email->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_email_by_id_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/' . $email->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_email_by_address()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/address/' . $email->address, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_email_by_address_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/address/' . $email->address)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_emails_by_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/account/id/' . $account->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
        #->seeJsonStructure($this->paginatedStructure); # @todo define this structure
    }

    /** @test */
    public function fails_to_get_emails_by_account_id_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/account/id/' . $account->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_emails_by_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/account/identifier/' . $account->identifier, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
        #->seeJsonStructure($this->paginatedStructure); # @todo define this structure
    }

    /** @test */
    public function fails_to_get_emails_by_account_identifier_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/account/identifier/' . $account->identifier)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_emails_by_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/account/username/' . $account->username, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
        #->seeJsonStructure($this->paginatedStructure); # @todo define this structure
    }

    /** @test */
    public function fails_to_get_emails_by_account_username_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Email::create(jediMasterEmail());
        $this->get('/api/v1/emails/account/username/' . $account->username)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_an_email()
    {
        Account::create(lukeSkywalkerAccount());
        $this->post('/api/v1/emails', jediMasterEmail(), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_an_email_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $this->post('/api/v1/emails', jediMasterEmail())
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_an_email_with_username()
    {
        Account::create(lukeSkywalkerAccount());
        $this->post('/api/v1/emails', jediMasterEmail(true, false), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_an_email_with_username_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $this->post('/api/v1/emails', jediMasterEmail(true, false))
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_an_email_with_identifier()
    {
        Account::create(lukeSkywalkerAccount());
        $this->post('/api/v1/emails', jediMasterEmail(false, true), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_an_email_with_identifier_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $this->post('/api/v1/emails', jediMasterEmail(false, true))
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_can_destroy_email_by_id()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());
        $this->delete('/api/v1/emails', ['id' => $email->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_destroy_email_by_id_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());
        $this->delete('/api/v1/emails', ['id' => $email->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_can_destroy_email_by_address()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());
        $this->delete('/api/v1/emails', ['address' => $email->address], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_destroy_email_by_address_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());
        $this->delete('/api/v1/emails', ['address' => $email->address])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
