<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\MobileCarrier;

class TokenVerificationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        [
            'id',
            'type',
            'message'
        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Account::class, 50)->create();
        $this->logIn();
    }

    /** @test */
    public function can_verify_email_token_with_get()
    {
        Account::create(lukeSkywalkerAccount());

        $email_response = $this->post('/api/v1/emails', jediMasterEmail(), ['Authorization' => 'Bearer ' . $this->bearer]);
        $email_response->seeStatusCode(201);
        $email_response->seeJsonStructure($this->itemStructureResponse);

        $data = $email_response->decodeResponseJson()['data'];
        $token = $data['verification_token'];

        $verify_response = $this->get('/api/v1/verify/' . $token);
        $verify_response->seeStatusCode(202);
        $verify_response->seeJsonStructure($this->itemStructureResponse);
        $verify_response->seeHeader('location', 'http://localhost/api/v1/emails/' . $data['id']);

    }

    /** @test */
    public function can_verify_mobile_phone_token_with_get()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());

        $phone_response = $this->post('/api/v1/mobile-phones', jediMasterMobilePhone(), ['Authorization' => 'Bearer ' . $this->bearer]);
        $phone_response->seeStatusCode(201);
        $phone_response->seeJsonStructure($this->itemStructureResponse);

        $data = $phone_response->decodeResponseJson()['data'];
        $token = $data['verification_token'];

        $verify_response = $this->get('/api/v1/verify/' . $token);
        $verify_response->seeStatusCode(202);
        $verify_response->seeJsonStructure($this->itemStructureResponse);
        $verify_response->seeHeader('location', 'http://localhost/api/v1/mobile-phones/' . $data['id']);

    }

    /** @test */
    public function can_verify_email_token_with_post()
    {
        Account::create(lukeSkywalkerAccount());

        $email_response = $this->post('/api/v1/emails', jediMasterEmail(), ['Authorization' => 'Bearer ' . $this->bearer]);
        $email_response->seeStatusCode(201);
        $email_response->seeJsonStructure($this->itemStructureResponse);

        $data = $email_response->decodeResponseJson()['data'];
        $token = $data['verification_token'];

        $verify_response = $this->post('/api/v1/verify', ['token' => $token]);
        $verify_response->seeStatusCode(202);
        $verify_response->seeJsonStructure($this->itemStructureResponse);
        $verify_response->seeHeader('location', 'http://localhost/api/v1/emails/' . $data['id']);
    }

    /** @test */
    public function can_verify_mobile_phone_token_with_post()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());

        $phone_response = $this->post('/api/v1/mobile-phones', jediMasterMobilePhone(), ['Authorization' => 'Bearer ' . $this->bearer]);
        $phone_response->seeStatusCode(201);
        $phone_response->seeJsonStructure($this->itemStructureResponse);

        $data = $phone_response->decodeResponseJson()['data'];
        $token = $data['verification_token'];

        $verify_response = $this->post('/api/v1/verify', ['token' => $token]);
        $verify_response->seeStatusCode(202);
        $verify_response->seeJsonStructure($this->itemStructureResponse);
        $verify_response->seeHeader('location', 'http://localhost/api/v1/mobile-phones/' . $data['id']);

    }

}
