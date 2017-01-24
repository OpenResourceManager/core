<?php

use App\Http\Models\API\Country;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\MobilePhone;
use App\Http\Models\API\Duty;
use App\Http\Models\API\MobileCarrier;

class MobilePhoneTest extends TestCase
{
    use DatabaseTransactions;

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
    public function can_get_verified_mobile_phone_pages()
    {
        $this->get('/api/v1/mobile-phones/verified', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
    }

    /** @test */
    public function can_get_unverified_mobile_phone_pages()
    {
        $this->get('/api/v1/mobile-phones/unverified', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
    }

    /** @test */
    public function fails_to_get_mobile_phone_pages_without_auth()
    {
        $this->get('/api/v1/mobile-phones?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_mobile_phone_by_id()
    {
        $this->get('/api/v1/mobile-phones/' . MobilePhone::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_mobile_phone_by_id_without_auth()
    {
        $this->get('/api/v1/mobile-phones/' . MobilePhone::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_mobile_phones_by_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/account/id/' . $account->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
        #->seeJsonStructure($this->paginatedStructure); # @todo define this structure
    }

    /** @test */
    public function fails_to_get_mobile_phones_by_account_id_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/account/id/' . $account->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_mobile_phones_by_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/account/identifier/' . $account->identifier, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
        #->seeJsonStructure($this->paginatedStructure); # @todo define this structure
    }

    /** @test */
    public function fails_to_get_mobile_phones_by_account_identifier_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/account/identifier/' . $account->identifier)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_mobile_phones_by_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/account/username/' . $account->username, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
        #->seeJsonStructure($this->paginatedStructure); # @todo define this structure
    }

    /** @test */
    public function fails_to_get_mobile_phones_by_account_username_without_auth()
    {
        $account = Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/account/username/' . $account->username)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_mobile_phones_by_mobile_carrier_id()
    {
        Account::create(lukeSkywalkerAccount());
        $carrier = MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/mobile-carrier/id/' . $carrier->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
        #->seeJsonStructure($this->paginatedStructure); # @todo define this structure
    }

    /** @test */
    public function fails_to_get_mobile_phones_by_mobile_carrier_id_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $carrier = MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/mobile-carrier/id/' . $carrier->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_mobile_phones_by_mobile_carrier_code()
    {
        Account::create(lukeSkywalkerAccount());
        $carrier = MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/mobile-carrier/code/' . $carrier->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200);
        #->seeJsonStructure($this->paginatedStructure); # @todo define this structure
    }

    /** @test */
    public function fails_to_get_mobile_phones_by_mobile_carrier_code_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        $carrier = MobileCarrier::create(jediMasterMobileCarrier());
        MobilePhone::create(jediMasterMobilePhone());

        $this->get('/api/v1/mobile-phones/mobile-carrier/code/' . $carrier->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_a_mobile_phone()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        $this->post('/api/v1/mobile-phones/', jediMasterMobilePhone(), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_a_mobile_phone_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        $this->post('/api/v1/mobile-phones/', jediMasterMobilePhone())
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_a_mobile_phone_with_carrier_code()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        $this->post('/api/v1/mobile-phones/', jediMasterMobilePhone($useCode = true), ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_a_mobile_phone_with_carrier_code_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        $this->post('/api/v1/mobile-phones/', jediMasterMobilePhone($useCode = true))
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_a_mobile_phone_with_username()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        $phone = jediMasterMobilePhone(false, true, false);

        $this->post('/api/v1/mobile-phones/', $phone, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_a_mobile_phone_with_username_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        $phone = jediMasterMobilePhone(false, true, false);

        $this->post('/api/v1/mobile-phones/', $phone)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_a_mobile_phone_with_identifier()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        $phone = jediMasterMobilePhone(false, false, true);

        $this->post('/api/v1/mobile-phones/', $phone, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_a_mobile_phone_with_identifier_without_auth()
    {
        Account::create(lukeSkywalkerAccount());
        MobileCarrier::create(jediMasterMobileCarrier());
        $phone = jediMasterMobilePhone(false, false, true);

        $this->post('/api/v1/mobile-phones/', $phone)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_mobile_phone()
    {
        $id = MobilePhone::get()->random()->id;
        $this->delete('/api/v1/mobile-phones', ['id' => $id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);

    }

    /** @test */
    public function fails_to_delete_mobile_phone_without_auth()
    {
        $id = MobilePhone::get()->random()->id;
        $this->delete('/api/v1/mobile-phones', ['id' => $id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);

    }

}
