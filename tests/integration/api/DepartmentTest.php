<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Department;

class DepartmentTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'code',
            'academic',
            'label',
            'updated',
            'created',

        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Department::class, 250)->create();
        $this->logIn();
    }

    /** @test */
    public function can_get_department_pages()
    {
        $this->get('/api/v1/departments?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_department_pages_without_auth()
    {
        $this->get('/api/v1/departments?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_department()
    {
        $this->get('/api/v1/departments/' . Department::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_department_without_auth()
    {
        $this->get('/api/v1/departments/' . Department::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_department_with_code()
    {
        $this->get('/api/v1/departments/code/' . Department::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_department_with_code_without_auth()
    {
        $this->get('/api/v1/departments/code/' . Department::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_department()
    {
        $this->post('/api/v1/departments', ['label' => 'The Department', 'code' => 'CODZE1234', 'academic' => true], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_department_without_auth()
    {
        $this->post('/api/v1/departments', ['label' => 'The Department', 'code' => 'CODZE1234', 'academic' => true])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_department_by_id()
    {
        $this->delete('/api/v1/departments', ['id' => Department::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_department_by_id_without_auth()
    {
        $this->delete('/api/v1/departments', ['id' => Department::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_department_by_code()
    {
        $this->delete('/api/v1/departments', ['code' => Department::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_department_by_code_without_auth()
    {
        $this->delete('/api/v1/departments', ['code' => Department::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }
}
