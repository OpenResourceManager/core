<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Account;
use App\Http\Models\API\Email;
use App\Http\Models\API\Duty;

class EmailsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $errorStructure = ['message', 'status_code'];

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
    public function can_get_email_by_id()
    {
        Account::create(lukeSkywalkerAccount());
        $email = Email::create(jediMasterEmail());

        $this->get('/api/v1/emails/' . $email->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

}
