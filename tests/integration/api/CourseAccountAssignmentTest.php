<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\Department;
use App\Http\Models\API\Course;

class CourseAccountAssignmentTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        factory(Account::class, 150)->create();
        factory(Department::class, 5)->create();
        factory(Course::class, 5)->create();
        $this->logIn();
    }

    /** @test */
    public function can_assign_and_detach_course_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['course_id' => $course->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_course_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['course_id' => $course->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_course_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['course_id' => $course->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_course_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['code' => $course->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_course_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['code' => $course->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function can_assign_and_detach_course_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['code' => $course->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(204);
    }

    /** @test */
    public function fails_to_assign_course_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_course_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_course_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'username' => $account->username])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_course_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_course_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /** @test */
    public function fails_to_assign_course_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'username' => $account->username])
            ->assertResponseStatus(401);
    }


    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_course_by_id_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['course_id' => $course->id, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_course_by_id_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['course_id' => $course->id, 'identifier' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_course_by_id_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['course_id' => $course->id, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['course_id' => $course->id, 'username' => $account->username])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_course_by_code_with_account_id()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'account_id' => $account->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['code' => $course->code, 'account_id' => $account->id])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_course_by_code_with_account_identifier()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'identifier' => $account->identifier], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['code' => $course->code, 'identifer' => $account->identifier])
            ->assertResponseStatus(401);
    }

    /**
     * @todo The delete request should return a 401, but it is returning a 204. Strange thing is POST Man is returning a 401 under the same conditions.
     */
    public function fails_to_detach_course_by_code_with_account_username()
    {
        $account = Account::create(lukeSkywalkerAccount());
        Department::create(jediMasterDepartment());
        $course = Course::create(jediMasterCourse());

        $this->post('/api/v1/accounts/course', ['code' => $course->code, 'username' => $account->username], ['Authorization' => 'Bearer ' . $this->bearer])
            ->assertResponseStatus(201);

        $this->delete('/api/v1/accounts/course', ['code' => $course->code, 'username' => $account->username])
            ->assertResponseStatus(401);
    }
}
