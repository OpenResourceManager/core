<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\Department;
use App\Http\Models\API\Course;

class DepartmentAccountAssignmentTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        factory(Account::class, 150)->create();
        factory(Department::class, 5)->create();
        $this->logIn();
    }

    /** @test */
    public function can_assign_and_detach_department_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['department_id' => $department->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_department_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['department_id' => $department->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_department_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['department_id' => $department->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_department_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());
        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['code' => $department->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_department_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['code' => $department->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_department_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['code' => $department->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function fails_to_assign_department_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());
        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_department_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());
        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_department_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());
        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'username' => $account->username])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_department_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());
        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_department_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());
        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_department_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());
        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'username' => $account->username])
            ->assertResponseStatus(401);
    }


    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_department_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['department_id' => $department->id, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_department_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['department_id' => $department->id, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_department_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['department_id' => $department->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['department_id' => $department->id, 'username' => $account->username])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_department_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['code' => $department->code, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_department_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['code' => $department->code, 'identifer' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_department_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        $department = Department::create(jediMasterDepartment());

        $this->post('/api/v1/accounts/department', ['code' => $department->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/department', ['code' => $department->code, 'username' => $account->username])
            ->assertResponseStatus(401);
    }
}
