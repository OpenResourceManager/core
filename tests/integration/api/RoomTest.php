<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Models\API\Campus;
use App\Http\Models\API\Building;
use App\Http\Models\API\Room;

class RoomTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $itemStructureResponse = [
        'data' => [
            'id',
            'code',
            'floor_number',
            'floor_label',
            'room_number',
            'room_label',
            'updated',
            'created',
            'building',
        ]
    ];

    public function setUp()
    {
        parent::setUp();
        factory(Campus::class, 5)->create();
        factory(Building::class, 50)->create();
        factory(Room::class, 300)->create();
        $this->logIn();
    }

    /** @test */
    public function can_get_rooms_pages()
    {
        $this->get('/api/v1/rooms?page=2', ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->paginatedStructure);
    }

    /** @test */
    public function fails_to_get_rooms_pages_without_auth()
    {
        $this->get('/api/v1/rooms?page=2')
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_room()
    {
        $this->get('/api/v1/rooms/' . Room::get()->random()->id, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_room_without_auth()
    {
        $this->get('/api/v1/rooms/' . Room::get()->random()->id)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_get_room_by_code()
    {
        $this->get('/api/v1/rooms/code/' . Room::get()->random()->code, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(200)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_get_room_by_code_without_auth()
    {
        $this->get('/api/v1/rooms/code/' . Room::get()->random()->code)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_room()
    {
        $room = [
            'code' => 'ThisIsACode',
            'building_id' => Building::get()->random()->id,
            'floor_number' => 1,
            'floor_label' => 'First Floor',
            'room_number' => 100,
            'room_label' => 'Mt. Hood Room',
        ];
        $this->post('/api/v1/rooms', $room, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_room_without_auth()
    {
        $room = [
            'code' => 'ThisIsACode',
            'building_id' => Building::get()->random()->id,
            'floor_number' => 1,
            'floor_label' => 'First Floor',
            'room_number' => 100,
            'room_label' => 'Mt. Hood Room',
        ];
        $this->post('/api/v1/rooms', $room)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_create_room_with_building_code()
    {
        $room = [
            'code' => 'ThisIsACode',
            'building_code' => Building::get()->random()->code,
            'floor_number' => 1,
            'floor_label' => 'First Floor',
            'room_number' => 100,
            'room_label' => 'Mt. Hood Room',
        ];
        $this->post('/api/v1/rooms', $room, ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(201)
            ->seeJsonStructure($this->itemStructureResponse);
    }

    /** @test */
    public function fails_to_create_room_with_building_code_without_auth()
    {
        $room = [
            'code' => 'ThisIsACode',
            'building_code' => Building::get()->random()->code,
            'floor_number' => 1,
            'floor_label' => 'First Floor',
            'room_number' => 100,
            'room_label' => 'Mt. Hood Room',
        ];
        $this->post('/api/v1/rooms', $room)
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_room_by_id()
    {
        $this->delete('/api/v1/rooms', ['id' => Room::get()->random()->id], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_room_by_id_without_auth()
    {
        $this->delete('/api/v1/rooms', ['id' => Room::get()->random()->id])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

    /** @test */
    public function can_delete_room_by_code()
    {
        $this->delete('/api/v1/rooms', ['code' => Room::get()->random()->code], ['Authorization' => 'Bearer ' . $this->bearer])
            ->seeStatusCode(204);
    }

    /** @test */
    public function fails_to_delete_room_by_code_without_auth()
    {
        $this->delete('/api/v1/rooms', ['code' => Room::get()->random()->code])
            ->seeStatusCode(401)
            ->seeJsonStructure($this->errorStructure);
    }

}
