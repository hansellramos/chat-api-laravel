<?php

namespace Tests\Feature\Feature;

use App\Room;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomTest extends TestCase
{
    public function testRoomCreatedSuccessfully()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $payload = [
            'name' => 'Room name',
            'description' => 'Room description'
        ];

        $this->json('post', 'api/rooms', $payload, $headers)
            ->assertStatus(201)
            ->assertJson([
                'id' => 1,
                'name' => 'Room name',
                'description' => 'Room description'
            ]);
    }

    public function testRoomUpdatedSuccessfully() {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $room = factory(Room::class)->create([
            'name' => 'Room Name',
            'description' => 'Room description'
        ]);

        $payload = [
            'name' => 'Updated Room Name',
            'description' => 'Updated Room description'
        ];

        $this->json('put', "api/rooms/$room->id", $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => $room->id,
                'name' => 'Updated Room Name',
                'description' => 'Updated Room description'
            ]);
    }

    public function testRoomIsDeletedProperly() {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $room = factory(Room::class)->create();

        $this->json('delete', "api/rooms/$room->id", [], $headers)
            ->assertStatus(204);
    }

    public function testRoomsAreListedProperly() {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        factory(Room::class)->create([
            'name' => 'Room name 1',
            'description' => 'Room description 1'
        ]);

        factory(Room::class)->create([
            'name' => 'Room name 2',
            'description' => 'Room description 2'
        ]);

        $this->json('get', 'api/rooms', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [
                    'name' => 'Room name 1',
                    'description' => 'Room description 1'
                ],
                [
                    'name' => 'Room name 2',
                    'description' => 'Room description 2'
                ]
            ])
            ->assertJsonStructure([
                '*' => [
                    'id', 'name', 'description', 'created_at', 'updated_at'
                ]
            ])
        ;
    }
}
