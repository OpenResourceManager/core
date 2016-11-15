<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Department;
use App\Http\Models\API\Course;

class CourseTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'code',
            'course_level',
            'label',
            'updated',
            'created',
            'department',

        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Department::class, 50)->create();
        factory(Course::class, 250)->create();
        $this->logIn();
    }


    /** @test */
    public function can_get_courses_pages()
    {
        $this->get('/api/v1/courses?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_courses_pages_without_auth()
    {
        $this->get('/api/v1/courses?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_course()
    {
        $this->get('/api/v1/courses/' . Course::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_course_without_auth()
    {
        $this->get('/api/v1/courses/' . Course::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_course_by_code()
    {
        $this->get('/api/v1/courses/code/' . Course::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_course_by_code_without_auth()
    {
        $this->get('/api/v1/courses/code/' . Course::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_course()
    {
        $this->post('/api/v1/courses', [
            'label' => 'The Code',
            'code' => 'CODZE1234',
            'course_level' => 100,
            'department_id' => Department::get()->random()->id
        ], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_course_without_auth()
    {
        $this->post('/api/v1/courses', [
            'label' => 'The Code',
            'code' => 'CODZE1234',
            'course_level' => 100,
            'department_id' => Department::get()->random()->id
        ])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_course_with_department_code()
    {
        $this->post('/api/v1/courses', [
            'label' => 'The Code',
            'code' => 'CODZE1234',
            'course_level' => 100,
            'department_code' => Department::get()->random()->code
        ], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_course_with_department_code_without_auth()
    {
        $this->post('/api/v1/courses', [
            'label' => 'The Code',
            'code' => 'CODZE1234',
            'course_level' => 100,
            'department_code' => Department::get()->random()->code
        ])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_course_by_id()
    {
        $this->delete('/api/v1/courses', ['id' => Course::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_course_by_id_without_auth()
    {
        $this->delete('/api/v1/courses', ['id' => Course::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_course_by_code()
    {
        $this->delete('/api/v1/courses', ['code' => Course::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_course_by_code_without_auth()
    {
        $this->delete('/api/v1/courses', ['code' => Course::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
