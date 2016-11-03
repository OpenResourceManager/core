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
    public function lukeSkywalkerAccount()
    {
        return [
            'identifier' => '9999999',
            'name_prefix' => 'Mr.',
            'name_first' => 'Luke',
            'name_middle' => 'Cliegg',
            'name_last' => 'Lars',
            'name_postfix' => 'Jedi',
            'name_phonetic' => 'Luke Skywalker',
            'username' => 'skwall',
            'primary_duty' => Duty::firstOrFail()->id,
        ];
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

}
