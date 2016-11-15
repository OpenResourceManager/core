<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\Duty;

class DutyAccountAssignmentTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        factory(Account::class, 150)->create();
        factory(Duty::class, 5)->create();
        $this->logIn();
    }

    /** @test */
    public function can_assign_and_detach_duty_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_duty_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_duty_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_duty_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());
        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['code' => $duty->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_duty_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['code' => $duty->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_duty_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['code' => $duty->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function fails_to_assign_duty_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());
        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_duty_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());
        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_duty_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());
        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'username' => $account->username])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_duty_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());
        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_duty_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());
        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_duty_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());
        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'username' => $account->username])
            ->assertResponseStatus(401);
    }


    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_duty_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_duty_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_duty_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['duty_id' => $duty->id, 'username' => $account->username])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_duty_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['code' => $duty->code, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_duty_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['code' => $duty->code, 'identifer' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_duty_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $duty = Duty::create(jediMasterDuty());

        $this->post('/api/v1/accounts/duty', ['code' => $duty->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/duty', ['code' => $duty->code, 'username' => $account->username])
            ->assertResponseStatus(401);
    }
}
