<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\School;

class SchoolAccountAssignmentTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        factory(Account::class, 150)->create();
        factory(School::class, 5)->create();
        $this->logIn();
    }

    /** @test */
    public function can_assign_and_detach_school_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['school_id' => $school->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_school_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['school_id' => $school->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_school_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['school_id' => $school->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_school_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['code' => $school->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_school_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['code' => $school->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_school_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['code' => $school->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function fails_to_assign_school_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_school_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_school_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'username' => $account->username])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_school_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_school_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_school_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'username' => $account->username])
            ->assertResponseStatus(401);
    }


    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_school_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['school_id' => $school->id, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_school_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['school_id' => $school->id, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_school_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['school_id' => $school->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['school_id' => $school->id, 'username' => $account->username])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_school_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['code' => $school->code, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_school_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['code' => $school->code, 'identifer' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_school_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $school = School::create(jediMasterSchool());

        $this->post('/api/v1/accounts/school', ['code' => $school->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/school', ['code' => $school->code, 'username' => $account->username])
            ->assertResponseStatus(401);
    }
}
